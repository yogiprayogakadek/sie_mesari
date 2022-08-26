<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return view('sale.index');
    }

    public function search($slug)
    {
        $product = Product::with('attribute')->where('name', 'LIKE', '%' . $slug . '%')->get();

        return response()->json($product);
    }
}
