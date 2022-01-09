<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Remainder;
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
        $months = $this->getMonths($month);
        $current = Order::query()->select(
            'shop as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->where('date', 'like', "2021-$months[0]%")
            ->groupBy('shop')
            ->get()->toArray();

        $previous = Order::query()->select(
            'shop as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->where('date', 'like', "2021-$months[1]%")
            ->groupBy('name')
            ->get()->toArray();
        $data = $this->getStatistics($current, $previous);

        return view('teko', compact('data', 'month'));
    }

    public function torg3(int $month, string $shop)
    {
        $months = $this->getMonths($month);
        $shop = str_replace('+', ' ', $shop);
        $current = Order::query()->select(
            'torg3 as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[0]%")
            ->where('shop', $shop)
            ->groupBy('torg3')
            ->get()->toArray();

        $previous = Order::query()->select(
            'torg3 as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[1]%")
            ->where('shop', $shop)
            ->groupBy('torg3')
            ->get()->toArray();
        $data = $this->getStatistics($current, $previous);

        return view('teko', compact('data', 'month', 'shop'));
    }

    public function TM($month, $shop, $torg3)
    {
        $months = $this->getMonths($month);
        $torg3 = str_replace('+', ' ', $torg3);
        $current = Order::query()->select(
            'tm as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[0]%")
            ->where('shop', $shop)
            ->where('torg3', $torg3)
            ->groupBy('tm')
            ->get()->toArray();
        $previous = Order::query()->select(
            'tm as name', DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[1]%")
            ->where('shop', $shop)
            ->where('torg3', $torg3)
            ->groupBy('tm')
            ->get()->toArray();
        $data = $this->getStatistics($current, $previous);


        return view('teko', compact('data', 'month', 'shop', 'torg3'));
    }

    public function product($month, $shop, $torg3, $tm)
    {
        $months = $this->getMonths($month);
        $shop = str_replace('+', ' ', $shop);
        $torg3 = str_replace('+', ' ', $torg3);
        $tm = str_replace('+', ' ', $tm);
        $current = Order::query()->select(
            'orders.article', 'torg3.name',
            DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[0]%")
            ->where('shop', $shop)
            ->where('torg3', $torg3)
            ->where('tm', $tm)
            ->groupBy('orders.article', 'torg3.name')
            ->get()->toArray();
        $previous = Order::query()->select(
            'orders.article', 'torg3.name',
            DB::raw('ROUND(SUM(`count`), 2) as count')
        )
            ->join('torg3', 'torg3.article', '=', 'orders.article')
            ->where('date', 'like', "2021-$months[1]%")
            ->where('shop', $shop)
            ->where('torg3', $torg3)
            ->where('tm', $tm)
            ->groupBy('orders.article', 'torg3.name')
            ->get()->toArray();
        $data = $this->getStatistics($current, $previous);


        return view('teko', compact('data', 'month', 'shop', 'torg3', 'tm'));

    }

    public function remainder($month, $shop, $torg3, $tm, $article)
    {
        $months = $this->getMonths($month);
        $shop = str_replace('+', ' ', $shop);
        $data = Remainder::query()->select(
            'date', 'count'
        )
            ->join('torg3', 'torg3.article', '=', 'remainders.article')
            ->where('date', 'like', "2021-$months[0]%")
            ->where('shop', $shop)
            ->where('remainders.article', $article)
            ->get()->toArray();
        return view(
            'remainder',
            compact('data', 'month', 'shop', 'torg3', 'tm', 'article')
        );
    }

    private function getStatistics(array $current, array $previous
    ): array {
        $data = [];
        $names = array_unique(Arr::pluck($current + $previous, 'name'));

        foreach ($names as $name) {
            $currentStatistics = Arr::first(
                $current, function ($value, $key) use ($name) {
                return $value['name'] == $name;
            }
            );
            $previousStatistics = Arr::first(
                $previous, function ($value, $key) use ($name) {
                return $value['name'] == $name;
            }
            );
            $currentStatistics['count'] = $currentStatistics['count'] ?? 0;
            $previousStatistics['count'] = $previousStatistics['count'] ?? 0;
            $data[] = [
                'name' => $name,
                'previousCount' => $previousStatistics['count'],
                'currentCount' => $currentStatistics['count'],
                'diff' => round(
                    $previousStatistics['count']
                    - $currentStatistics['count'], 2
                ),
                'article' => $currentStatistics['article'] ?? null
            ];
        }


        usort($data, function ($item1, $item2) {
            return $item1["diff"] <=> $item2["diff"];
        });

        return $data;
    }

    private function getMonths(int $month): array
    {
        $previous = strval($month - 1);
        $previous = strlen($previous) > 1 ? $previous
            : '0'.$previous;
        $current = strval($month);
        $current = strlen($current) > 1 ? $current
            : '0'.$current;
        return [$current, $previous];
    }
}
