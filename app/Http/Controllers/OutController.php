<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Remainder;
use App\Models\Torg3;

class OutController extends Controller
{
    public function index()
    {
        $shops = Order::select('shop')->distinct()->orderBy('shop')->get()->toArray();
        $data = $shops;
        return view('Out.index', compact('data'));
    }

    public function outStock(string $shop)
    {
        $day = Remainder::select('date')->max('date');
        $top = Order::groupBy('article')
            ->selectRaw('article, SUM(sum) as sum')
            ->whereRaw('date BETWEEN \'' . $day . '\' - INTERVAL 1 MONTH and \'' . $day . '\'')
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
                ->orderBy('date')
                ->get()
                ->pluck('date')
                ->toArray();
            $data[$out['article']]['days'] = $days;
            $data[$out['article']]['fields'] = $this->getFields($out);
        }

        return view('Out.index', compact('data'));

    }

    private function getFields(string $out): array
    {
        $fields = Torg3::select('tm', 'name');
    }
}
