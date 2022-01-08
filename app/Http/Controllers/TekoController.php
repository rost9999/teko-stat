<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Teko;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TekoController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function statistics(int $month)
    {
        $current = Order::query()->select('mag', DB::raw('SUM(count) as count'))
            ->whereYear('date', 2021)
            ->whereMonth('date', $month)
            ->groupBy('mag')
            ->get()->toArray();
        $previous = Order::query()->select('mag', DB::raw('SUM(count) as count'))
            ->whereYear('date', 2021)
            ->whereMonth('date', $month - 1)
            ->groupBy('mag')
            ->get()->toArray();
        $data = $this->getStatistics($current, $previous);

        return view('old-teko', compact('data'));
    }

    public function grupa(int $month, strting $shop)
    {
        $data = DB::select('SELECT `torg3` as `Група`, ROUND(sum(`count`),2) as `Різниця в К-сть` FROM `tekos` WHERE `mounth` = :month and `mag` = :mag GROUP BY `torg3` ORDER BY `Різниця в К-сть`', ['month' => $month, 'mag' => $shop]);
        $data = Order::query()->select('torg3', DB::raw('SUM(count)'))
            ->join('torg3',)
            ->whereYear('date', 2021)
            ->whereMonth('date', $month)
            ->where('shop', $shop)
            ->groupBy('torg3');



        return view('teko', compact('data'));
    }

    public function TM($month, $mag, $grupa)
    {
        $grupa = str_replace('+', ' ', $grupa);
        $data = DB::select('SELECT `TM` as `Торгова Марка`, ROUND(sum(`count`),2) as `Різниця в К-сть` FROM `tekos` WHERE `mounth` = :month and `mag` = :mag and `torg3` = :grupa GROUP BY `TM` ORDER BY `Різниця в К-сть`', ['month' => $month, 'mag' => $mag, 'grupa' => $grupa]);
        return view('teko', compact('data'));
    }

    public function tovar($month, $mag, $grupa, $tm)
    {
        $grupa = str_replace('+', ' ', $grupa);
        $tm = str_replace('+', ' ', $tm);
        $data = DB::select('SELECT `name` as `Назва`, ROUND(sum(`count`),2) as `Різниця в К-сть`, `article` FROM `tekos` WHERE `mounth` = :month and `mag` = :mag and `torg3` = :grupa and `TM` = :TM GROUP BY `article` ORDER BY `Різниця в К-сть`', ['month' => $month, 'mag' => $mag, 'grupa' => $grupa, 'TM' => $tm]);
        return view('teko', compact('data'));
    }

    public function remainder($month, $mag, $grupa, $tm, $article)
    {
        $month = strval($month);
        if (strlen($month) < 2) {
            $month = '0' . $month;
        }
        $date = '%' . $month . '.2021';
        $data = DB::select('SELECT `date`, ROUND(`count`,2) as `count`  FROM remainders WHERE `mag` = :mag AND `article` = :article AND `date` LIKE :date ORDER BY `date`', ['mag' => $mag, 'article' => $article, 'date' => $date]);
        $newdata = [];
        foreach ($data as $d) {
            $newdata[substr($d->date, 0, 2)] = $d->count;
        }
        $data = $newdata;
        return view('remainder', compact('data'));
    }

    private function getStatistics(array $current, array $previous): array
    {
        $data = [];
        $shops = Arr::pluck(array_merge($current, $previous), 'mag');

        foreach ($shops as $shop) {
            $currentStatistics = Arr::first($current, function ($value, $key) use ($shop) {
                return $value['mag'] = $shop;
            });
            $previousStatistics = Arr::first($previous, function ($value, $key) use ($shop) {
                return $value['mag'] = $shop;
            });
            $diff = $currentStatistics['count'] - $previousStatistics['count'];

            $data[] = [
                'shop' => $shop,
                'currentCount' => $currentStatistics['count'],
                'previousCount' => $previousStatistics['count'],
                'diff' => $diff
            ];
        }

        uasort($data, function ($item1, $item2) {
            return $item1["diff"] <=> $item2["diff"];
        });

        return $data;
    }
}
