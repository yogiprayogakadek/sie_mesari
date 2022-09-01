<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $member = Member::pluck('name', 'id')->prepend('Tidak ada kartu member', 'none')->toArray();
        return view('sale.index', compact('member'));
    }

    public function search($slug)
    {
        $product = Product::with('attribute')->where('name', 'LIKE', '%' . $slug . '%')->get();

        return response()->json($product);
    }

    public function detail()
    {
        $data = Sale::with('detail.product', 'member', 'staff')->get();
        return view('sale.detail', compact('data'));
    }

    public function detailRender()
    {
        $data = Sale::with('detail.product', 'member', 'staff')->get();
        
        $view = [
            'data' => view('sale.detail.update', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function detailFilter($start, $end)
    {
        $data = Sale::with('detail.product', 'member', 'staff')->whereBetween('sale_date', [$start, $end])->get();
        $view = [
            'data' => view('sale.detail.update', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function print($start, $end)
    {
        $data = Sale::with('detail.product', 'member', 'staff')->whereBetween('sale_date', [$start, $end])->get();
        $view = [
            'data' => view('sale.detail.print', compact('data'))->render()
        ];

        return response()->json($view);
    }
}
