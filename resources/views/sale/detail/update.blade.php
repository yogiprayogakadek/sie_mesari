<table class="table table-stripped" id="tableData">
    <thead>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Staff</th>
        <th>Member</th>
        <th>Discount</th>
        <th>Total</th>
        <th>Tanggal Transaksi</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->transaction_code}}</td>
                <td>{{$data->staff->name}}</td>
                <td>{{$data->member_id != null ? $data->member->name : '-'}}</td>
                <td>{{$data->discount}}%</td>
                <td>{{convertToRupiah($data->total)}}</td>
                <td>{{$data->sale_date}}</td>
                <td>
                    <button class="btn btn-primary btn-detail" data-id="{{$data->id}}">Detail</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
            </div>
            <div class="modal-body">
                <table class="table table-stripped" id="tableDetail">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tableData').DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            lengthMenu: "Menampilkan _MENU_ data",
            search: "Cari:",
            emptyTable: "Tidak ada data tersedia",
            zeroRecords: "Tidak ada data yang cocok",
            loadingRecords: "Memuat data...",
            processing: "Memproses...",
            infoFiltered: "(difilter dari _MAX_ total data)"
        },
        lengthMenu: [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
    });

    $('body').on('click', '.btn-detail', function() {
        let sale_id = $(this).data('id');
        $('#modalDetail').modal('show');

        $.get("/sale/find-by-id/"+sale_id, function (data) {
            $('#tableDetail tbody').empty();
            $.each(data.detail, function (index, value) { 
                let tr_list = '<tr>' +
                                '<td>' + value.no + '</td>' +
                                '<td>' + value.product_name + '</td>' +
                                '<td>' + value.product_price + '</td>' +
                                '<td>' + value.quantity + '</td>' +
                                '<td>' + value.subtotal + '</td>' +
                            '</tr>';
                
                $('#tableDetail tbody').append(tr_list);
            });
        });
    });
</script>