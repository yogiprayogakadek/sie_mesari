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

?>