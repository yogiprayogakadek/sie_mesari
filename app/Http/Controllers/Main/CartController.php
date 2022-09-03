<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\Sale;
use App\Models\SaleDetail;
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
                if($product->attribute == null || $product->attribute->stock <= 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tidak ada stok untuk produk ini',
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
                    ]);
                }
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
        $user_id = auth()->user()->id;
        $product = Product::with('attribute')->where('id', $request->id)->first();
        if($request->qty > $product->attribute->stock) {
            return response()->json([
                'status' => 'info',
                'message' => 'Stok tidak mencukupi, stok yang tersedia ' . $product->attribute->stock,
                'title' => 'Info',
            ]);
        } else {
            \Cart::session($user_id)->update($request->id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty
                ],
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Kuantitas berhasil diubah',
                'title' => 'Berhasil',
                'cart' => cart(),
                'subtotal' => subTotal()
            ]);
        }
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

    public function checkout(Request $request)
    {
        try {
            // before discount
            $totalBeforeDiscount = ($request->total*100)/(100-$request->discount);
            $point = floor($totalBeforeDiscount/20000);

            $sale = Sale::create([
                'transaction_code' => generateTransactionCode(),
                'staff_id' => auth()->user()->staff->id,
                'member_id' => $request->member_id == 'none' ? null : $request->member_id,
                'discount' => $request->discount,
                'total' => $request->total,
                'sale_date' => date('Y-m-d H:i:s')
            ]);

            if($request->member_id != null) {
                $member = Member::find($request->member_id);
                $member->update([
                    'point' => $member->point + $point
                ]);
            }

            foreach (cart() as $d) {
                $produk = Product::find($d->id);
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $d->id,
                    'quantity' => $d->quantity,
                ]);

                $produk->attribute->update([
                    'stock' => $produk->attribute->stock - $d->quantity
                ]);
            }

            clearCart();

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil diproses',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Peminjaman gagal diproses',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function check()
    {
        dd(\Cart::session(auth()->user()->id)->getContent());
    }
}
