<?php

    function account_image()
    {
        return asset(auth()->user()->image);
    }

    function username()
    {
        return auth()->user()->username;
    }

    function role()
    {
        return auth()->user()->role->name;
    }

    function convertToRupiah($jumlah)
    {
        return 'Rp' . number_format($jumlah, 0, '.', '.');
    }

    function cart()
    {
        return \Cart::session(auth()->user()->id)->getContent();
    }

    function subTotal()
{
    $user_id = auth()->user()->id;
    $cart = \Cart::session($user_id)->getContent();
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price * $item->quantity;
    }

    return convertToRupiah($subtotal);
}

?>