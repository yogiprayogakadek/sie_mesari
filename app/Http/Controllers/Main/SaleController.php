<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $member = Member::pluck('name', 'id')->prepend('Tidak ada kartu member', 'none')->toArray();
        return view('sale.index', compact('member'));
    }

    public function search($slug)
    {
        $product = Product::whereHas('category',function($query) {
            $query->where('status', true);
        })->with('attribute')
        ->where('name', 'LIKE', '%' . $slug . '%')
        ->where('status', true)
        ->get();

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
        $netto = Sale::whereBetween('sale_date', [$start, $end])
                        ->select(DB::raw("SUM(total - (total * (discount/100))) as total"))->get();
                        
        $bruto = Sale::whereBetween('sale_date', [$start, $end])->sum('total');

        $discount = Sale::whereBetween('sale_date', [$start, $end])
                        ->select(DB::raw("SUM((total * (discount/100))) as total"))->get();
        $view = [
            'data' => view('sale.detail.print')->with([
                'data' => $data,
                'netto' => convertToRupiah($netto[0]->total),
                'bruto' => convertToRupiah($bruto),
                'discount' => convertToRupiah($discount[0]->total)
            ])->render()
        ];

        return response()->json($view);
    }

    public function findById($sale_id)
    {
        $sale = Sale::where('id', $sale_id)->with('detail.product')->first();
        $data = [];

        foreach($sale->detail as $key => $detail) {
            $data['detail'][] = [
                'no' => $key+1,
                'product_name' => $detail->product->name,
                'product_price' => convertToRupiah($detail->product->price),
                'quantity' => $detail->quantity,
                'subtotal' => convertToRupiah($detail->product->price * $detail->quantity)
            ];
        }

        $data['discount'] = $sale->discount . '%';
        $data['grand_total'] = convertToRupiah($sale->total);

        // dd($data);
        return response()->json($data);
    }
}
