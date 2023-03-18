<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use DateTime;
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
            $start_date = DateTime::createFromFormat('d-m-Y', $request->start_date);
            $end_date = DateTime::createFromFormat('d-m-Y', $request->end_date);
            $data = DB::table('products')
                    ->select('products.id', 'products.name', DB::raw('SUM(sale_details.quantity) as quantity'))
                    ->leftJoin('sale_details', 'products.id', '=', 'sale_details.product_id')
                    ->leftJoin('sales', 'sale_details.sale_id', '=', 'sales.id')
                    ->whereBetween('sales.sale_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
                    // ->whereMonth('sales.sale_date', $request->bulan)
                    // ->whereYear('sales.sale_date', $request->tahun)
                    ->groupBy('products.id')
                    ->get();
        }
        foreach ($data as $key => $value) {
            $chart[] = [
                'nama_produk' => $value->name,
                'jumlah' => $value->quantity,
            ];
        }
        $maxVal = array_keys(array_column($chart, 'jumlah'), max(array_column($chart, 'jumlah')));
        $minVal = array_keys(array_column($chart, 'jumlah'), min(array_column($chart, 'jumlah')));

        $terendahProduk = [];
        $terendahValue = [];
        $terendah = [];
        for($i = 0; $i < count($minVal); $i++) {
            array_push($terendahValue, $chart[$minVal[$i]]['jumlah']);
            array_push($terendahProduk, $chart[$minVal[$i]]['nama_produk']);
            array_push($terendah, $chart[$minVal[$i]]['nama_produk'] . ' dengan ' . $chart[$minVal[$i]]['jumlah'] . ' buah');
        }

        $tertinggiProduk = [];
        $tertinggiValue = [];
        $tertinggi = [];
        for($i = 0; $i < count($maxVal); $i++) {
            array_push($tertinggiValue, $chart[$maxVal[$i]]['jumlah']);
            array_push($tertinggiProduk, $chart[$maxVal[$i]]['nama_produk']);
            array_push($tertinggi, $chart[$maxVal[$i]]['nama_produk'] . ' ' . $chart[$maxVal[$i]]['jumlah'] . ' buah');
        }

        $view = [
            'data' => view('dashboard.chart.index')->with([
                'tanggal' => $start_date->format('Y-m-d') . ' s/d ' . $end_date->format('Y-m-d'),
                'chart' => $chart,
                'totalData' => count($data),
                'tertinggiProduk' => str_replace(',', ', ', str_replace(['["', '"]', '"'], '', json_encode($tertinggiProduk))),
                'tertinggiValue' => str_replace(' ', ', ', implode(" ", $tertinggiValue)),
                'terendahProduk' => str_replace(',', ', ', str_replace(['["', '"]', '"'], '', json_encode($terendahProduk))),
                'terendahValue' => str_replace(' ', ', ', implode(" ", $terendahValue)),
                
                'tertinggi' => str_replace(',', ', ', str_replace(['["', '"]', '"'], '', json_encode($tertinggi))),
                'terendah' => str_replace(',', ', ', str_replace(['["', '"]', '"'], '', json_encode($terendah)))
            ])->render()
        ];

        return response()->json($view);
    }

    public function chartTerlaris(Request $request)
    {
        // TERLARIS
        $start_date = DateTime::createFromFormat('d-m-Y', $request->start_date);
        $end_date = DateTime::createFromFormat('d-m-Y', $request->end_date);

        $data = DB::table('products')
            ->select('products.id', 'products.name', DB::raw('SUM(sale_details.quantity) as kuantitas'))
            ->leftJoin('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->leftJoin('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sale_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
            ->groupBy('products.id')
            ->get()->take(5)->toArray();

        usort($data, function($a, $b) {
            return $b->kuantitas - $a->kuantitas;
        });

        $terlaris = [];
        $produk = "";
        $kuantitas = "";
        foreach($data as $i => $v) {
            $terlaris[] = [
                'nama_produk' => $v->name,
                'kuantitas' => $v->kuantitas,
            ];
            $produk .= $v->name . ', ';
            $kuantitas .= $v->kuantitas . ', ';
        }

        $view = [
            'data' => view('dashboard.chart.terlaris')->with([
                'terlaris' => $terlaris,
                'produk' => substr_replace(rtrim($produk, ', '), ' dan', strrpos(rtrim($produk, ', '), ','), 1),
                'kuantitas' => substr_replace(rtrim($kuantitas, ', '), ' dan', strrpos(rtrim($kuantitas, ', '), ','), 1),
                'tanggal' => $start_date->format('Y-m-d') . ' s/d ' . $end_date->format('Y-m-d'),
            ])->render()
        ];

        // dd($terlaris);

        return response()->json($view);
    }

    public function chartPendapatan(Request $request)
    {
        // TERLARIS
        $start_date = DateTime::createFromFormat('d-m-Y', $request->start_date);
        $end_date = DateTime::createFromFormat('d-m-Y', $request->end_date);

        $data = Sale::groupBy('sale_date')
                    ->select('sale_date')
                    ->selectRaw('sum(total) as total')
                    ->whereBetween('sale_date', [$start_date, $end_date])
                    ->get();

        $pendapatan = [];
        foreach($data as $i => $v) {
            $pendapatan[] = [
                'tanggal' => date_format(date_create($v->sale_date), 'd-m-Y'),
                'total' => $v->total,
            ];
        }

        // dd(current($pendapatan)['tanggal']);

        $view = [
            'data' => view('dashboard.chart.pendapatan')->with([
                'pendapatan' => $pendapatan,
                'tertinggi' => current($pendapatan),
                'terendah' => end($pendapatan),
            ])->render()
        ];


        return response()->json($view);
    }
}
