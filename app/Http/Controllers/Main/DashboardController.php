<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function chart(Request $request)
    {
        $chart = array();
        if($request->filter == 'product') {
            $data = DB::table('products')
                    ->select('products.id', 'products.name', DB::raw('SUM(sale_details.quantity) as quantity'))
                    ->leftJoin('sale_details', 'products.id', '=', 'sale_details.product_id')
                    ->leftJoin('sales', 'sale_details.sale_id', '=', 'sales.id')
                    ->whereMonth('sales.sale_date', $request->bulan)
                    ->whereYear('sales.sale_date', $request->tahun)
                    ->groupBy('products.id')
                    ->get();
        }
        foreach ($data as $key => $value) {
            $chart[] = [
                'nama_produk' => $value->name,
                'jumlah' => $value->quantity,
            ];
        }
        $view = [
            'data' => view('dashboard.chart.index')->with([
                'bulan' => bulan()[$request->bulan-1],
                'tahun' => $request->tahun,
                'chart' => $chart,
                'totalData' => count($data),
                'tertinggi' => max($chart),
                'terendah' => min($chart),
            ])->render()
        ];

        return response()->json($view);
    }
}
