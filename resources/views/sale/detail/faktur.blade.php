<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @page { size: 7cm 15cm; }
        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            /* margin: 0 auto; */
            width: mm;
            background: #FFF;
        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: .9em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #invoice-POS #top,
        #invoice-POS #mid,
        #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
            font-size: 7pt;
        }

        #invoice-POS #top {
            min-height: 100px;
        }

        #invoice-POS #mid {
            min-height: 80px;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .logo {
            height: 40px;
            width: 150px;
            /* background: url(https://www.sistemit.com/wp-content/uploads/2020/02/SISTEMITCOM-smlest.png) no-repeat; */
            background-size: 150px 40px;
            margin-bottom: 20px;
        }

        /* #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(https://www.sistemit.com/wp-content/uploads/2020/02/SISTEMITCOM-smlest.png) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        } */

        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: .5em;
            background: #EEE;
        }

        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .itemtext {
            font-size: .5em;
        }

        #invoice-POS #legalcopy {
            margin-top: 5mm;
        }

        .payment {
            text-align: right;
        }
    </style>
</head>

<body translate="no">


    <div id="invoice-POS">
        <center id="top">
            <div class="logo">
                <img src="{{public_path() . '\\'. 'assets/images/logo.png'}}" height="70px">
            </div>
            <br>
            <p style="margin-top: 10px; font-size: 8px;">
                Jl.Nagasari Gang Jabejero III nomor 8 Jagapati, Abiansemal, Badung <br>
                085213615645
            </p>
        </center>
        <!--End InvoiceTop-->

        {{-- <div id="mid">
            <div class="info">
                <h2>Info Kontak</h2>
                <p>
                    Alamat : Jalan Katjong Seleman nomor 1 Darmasaba, Abiansemal, Badung</br>
                    Telephone : 08521361xxxx</br>
                </p>
            </div>
        </div> --}}
        <!--End Invoice Mid-->

        <hr style="border-style: dotted;" />
        @php
            date_default_timezone_set('Asia/Kuala_Lumpur');
        @endphp
        <table style="width: 100%; font-size: 8px;">
            <tr>
                <td style="width: 40%;">Nomor Ref</td>
                <td style="width: 60%;">: {{$penjualan->transaction_code}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Tanggal</td>
                <td style="width: 60%;">: {{date('d-m-Y')}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Jam</td>
                <td style="width: 60%;">: {{date('H:i:s')}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Kasir</td>
                <td style="width: 60%;">: {{username()}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Member</td>
                <td style="width: 60%;">: {{$penjualan->member_id != null ? $penjualan->member->name : '-'}}</td>
            </tr>
            @if ($penjualan->member_id != null)
            <tr>
                <td style="width: 40%;">Poin</td>
                <td style="width: 60%;">: {{$penjualan->member->point}}</td>
            </tr>
            @endif
        </table>

        <hr style="border-style: dotted;" />

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Item</h2>
                        </td>
                        <td class="Hours">
                            <h2>Qty</h2>
                        </td>
                        <td class="Rate">
                            <h2>Sub Total</h2>
                        </td>
                    </tr>

                    @foreach ($data as $item)
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext">{{$item->product->name}}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{$item->quantity}}</p>
                        </td>
                        <td class="tableitem" style="text-align: right;">
                            <p class="itemtext">{{rupiah($item->quantity * $item->product->price)}},-</p>
                        </td>
                    </tr>
                    @endforeach

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total sebelum diskon</h2>
                        </td>
                        <td class="payment">
                            <h2>{{rupiah($penjualan->total)}},-</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Diskon ({{$penjualan->discount}} %)</h2>
                        </td>
                        <td class="payment">
                            <h2>{{rupiah($penjualan->total * ($penjualan->discount/100))}},-</h2>
                        </td>
                    </tr>

                    {{-- <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Potongan</h2>
                        </td>
                        <td class="payment">
                            <h2>{{rupiah($penjualan->total * ($penjualan->diskon/100))}},-</h2>
                        </td>
                    </tr> --}}

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total sesudah diskon</h2>
                        </td>
                        <td class="payment">
                            <h2>{{rupiah($penjualan->total - ($penjualan->total * ($penjualan->discount/100)))}},-</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Uang dibayar</h2>
                        </td>
                        <td class="payment">
                            <h2>{{$tunai}},-</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Kembalian</h2>
                        </td>
                        <td class="payment">
                            <h2>{{$kembalian}},-</h2>
                        </td>
                    </tr>

                </table>
            </div>
            
            <hr style="border-style: dotted;" />

            <div id="legalcopy">
                <p class="legal" style="text-align: center">
                    <b>TERIMA KASIH</b> <br> Kami tunggu kedatangannya kembali
                </p>
            </div>

        </div>
        <!--End InvoiceBot-->
    </div>
    <!--End Invoice-->

</body>

</html>