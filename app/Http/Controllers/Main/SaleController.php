<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Product;
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
}
