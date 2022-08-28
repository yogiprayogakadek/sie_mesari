<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::find($request->id);
        $user_id = auth()->user()->id;

        try {
            if(\Cart::session($user_id)->get($product->id)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produk sudah ada di keranjang',
                    'title' => 'Gagal',
                ]);
            } else {
                \Cart::session($user_id)->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    // 'quantity' => $request->jumlah,
                    'associatedModel' => $product,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'title' => 'Berhasil',
                    'cart' => cart(),
                    'subtotal' => subTotal()
                    // 'cart' => view('templates.partials.header-update')->render(),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>$e->getMessage(),
                'title' => 'Gagal',
            ]);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        \Cart::session($user_id)->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diupdate',
            'title' => 'Berhasil',
            'cart' => cart(),
            'subtotal' => subTotal()
        ]);

    }

    public function remove($id)
    {
        $user = auth()->user()->id;
        \Cart::session($user)->remove($id);
        return response()->json([
            'cart' => cart(),
            'subtotal' => subTotal(),
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'title' => 'Berhasil'
        ]);
    }

    public function check()
    {
        dd(\Cart::session(auth()->user()->id)->getContent());
    }
}
