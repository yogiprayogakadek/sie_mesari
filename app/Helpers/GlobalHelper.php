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

    function clearCart()
    {
        return \Cart::session(auth()->user()->id)->clear();
    }
    
    function rupiah($jumlah)
    {
        return number_format($jumlah, 0, '.', '.');
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

    function generateTransactionCode()
    {
        // return "TRANSID-" . strtoupper(uniqid());
        return "TRANSID-" . bin2hex(random_bytes(4));
    }

    function menu()
    {
        $menu = [
            'Category', 'Product', 'Staff', 'Member', 'Sale'
        ];

        return $menu;
    }

    function indoMenu()
    {
        $menu = [
            'Kategori', 'Produk', 'Karyawan', 'Anggota', 'Transaksi'
        ];

        return $menu;
    }

    function RouteURL()
    {
        $url = [
            0 => 'category.index',
            1 => 'product.index',
            2 => 'staff.index',
            3 => 'member.index',
            4 => 'sale.index'
        ];

        return $url;
    }

    function totalData($model)
    {
        $a = 'App\Models\\' . $model;
        $total = $a::count();
        return $total;
    }

    function bulan()
    {
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
    
        return $bulan;
    }