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
    private $day;

    public function __construct()
    {
        $this->day = Remainder::select('date')->max('date');
    }

    public function byShop()
    {
        $data = $this->outStock($this->day);

        return view('Out.shop', ['data' => $data, 'day' => $this->day]);
    }

    public function byContractor()
    {
        $result = [];
        $data = $this->outStock($this->day);
        foreach ($data as $shop => $items) {
            foreach ($items as $item) {
                $result[$item["fields"]["contractor"]][] = [
                    'shop' => $shop,
                    'article' => $item["fields"]["article"],
                    'tm' => $item["fields"]["tm"],
                    'name' => $item["fields"]["name"],
                    'days' => $item['days']
                ];
            }
        }
        uasort($data, function ($item1, $item2) {
            return $item2["days"] <=> $item1["days"];
        });
        return view('Out.contractor', ['data' => $result, 'day' => $this->day]);
    }

    public function outStock(string $day): array
    {
        return Cache::rememberForever($day, function () use ($day) {
            $data = [];
            $shops = Order::select('shop')
                ->distinct()
                ->whereNotIn('shop', ['ТЕРНОПІЛЬ'])
                ->orderBy('shop')
                ->pluck('shop');

            foreach ($shops as $shop) {
                $top = $this->getTop($shop, $day);
                $allOut = $this->getOut($shop, $top, $day);

                $shopData = [];
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
                    $shopData[$out['article']]['days'] = count($days) - 1;
                    if (count($days) > 2) {
                        $shopData[$out['article']]['fields'] = $this->getFields($out['article'], $shop);
                    }
                }
                $shopData = array_filter($shopData, function ($item) {
                    return $item['days'] > 2;
                });
                uasort($shopData, function ($item1, $item2) {
                    return $item2["days"] <=> $item1["days"];
                });
                $data[$shop] = $shopData;
            }
            return $data;
        });
    }

    private function getFields(string $out, string $shop): array
    {
        $fields = Torg3::select('article', 'tm', 'name')
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

    private function checkSequence(array $days): array
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

    private function getTop(string $shop, $day): \Illuminate\Support\Collection
    {
        return Order::select('orders.article', DB::raw('SUM(`sum`) as sum'))
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
    }

    private function getOut($shop, \Illuminate\Support\Collection $top, $day): array
    {
        return Remainder::select('article')
            ->where('shop', $shop)
            ->where('date', '=', $day)
            ->where('count', 0)
            ->whereIn('article', $top)
            ->get()
            ->toArray();
    }
}
