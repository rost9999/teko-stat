<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Order;
use App\Models\Remainder;
use App\Models\Torg3;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OutController extends Controller
{
    public function index()
    {
        $day = Remainder::select('date')->max('date');
        $shops = Order::select('shop')
            ->distinct()
            ->whereNotIn('shop', ['ТЕРНОПІЛЬ'])
            ->orderBy('shop')
            ->pluck('shop');
        $data = [];
//        foreach ($shops as $shop) {
//            $data[$shop] = $this->outStock($shop, $day);
//        }
        $shop = 'БІЛЬЧЕ-ЗОЛОТЕ';
        $data[$shop] = $this->outStock($shop, $day);
        return view('Out.shop', compact('data'));
    }

    public function outStock(string $shop, string $day)
    {
        $top = Order::select('orders.article', DB::raw('SUM(`sum`) as sum'))
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->whereRaw('date BETWEEN \'' . $day . '\' - INTERVAL 1 MONTH and \'' . $day . '\'')
            ->where('shop', $shop)
            ->whereNotIn('groupTT', [
                'Виробництво',
                'Овочі Фрукти',
                'Тютюнові вироби',
                'Молокопродукти',
                'Яйця і яйцепродукти',
                'Хлібобулочні вироби',
                'Новорічні подарунки'
            ])
            ->groupBy('orders.article')
            ->orderBy('sum', 'DESC')
            ->limit(100)
            ->pluck('sum', 'article')
            ->keys();

        $allOut = Remainder::select('article')
            ->where('shop', $shop)
            ->where('date', '=', $day)
            ->where('count', 0)
            ->whereIn('article', $top)
            ->get()
            ->toArray();
        $data = [];
        foreach ($allOut as $out) {
            $days = Remainder::select('date')
                ->where('shop', $shop)
                ->where('article', $out)
                ->whereRaw('date BETWEEN \'' . $day . '\' - INTERVAL 1 MONTH and \'' . $day . '\'')
                ->where('count', 0)
                ->orderBy('date', 'DESC')
                ->get()
                ->pluck('date')
                ->toArray();
            $days = $this->checkSequence($days);
            $data[$out['article']]['days'] = count($days) - 1;
            if (count($days) > 2) {
                $data[$out['article']]['fields'] = $this->getFields($out['article'], $shop);
            }
        }
        $data = array_filter($data, function ($item) {
            return $item['days'] > 2;
        });
        uasort($data, function ($item1, $item2) {
            return $item1 <=> $item2;
        });
        $data = array_reverse($data);
        return $data;
//        return view('Out.shop', compact('data'));
    }

    private function getFields(string $out, string $shop): array
    {
        $fields = Torg3::select('tm', 'name')
            ->where('article', $out)
            ->get()
            ->toArray()[0];
        $contractor = Incoming::select('contractor')
            ->where('article', $out)
            ->where('shop', $shop)
            ->orderBy('date', 'DESC')
            ->get()
            ->toArray();
        $fields['contractor'] = count($contractor) > 0 ? $contractor[0]['contractor'] : '';

        return $fields;
    }

    public function checkSequence(array $days)
    {
        $result = [array_shift($days)];
        foreach ($days as $day) {
            $previousDay = Carbon::parse(end($result));
            $currentDay = Carbon::parse($day);
            $diff = $currentDay->diffInDays($previousDay);
            if ($diff == 1) {
                $result[] = $day;
            } else {
                break;
            }
        }
        return $result;
    }
}
