$(document).ready(function () {
    $('body').on('click', '.btn-search', function() {
        var slug = $('input[name=slug]').val()
        if(slug == '') {
            Swal.fire(
                'Info',
                'Mohon untuk mengisi data pencarian...',
                'info'
            );

            return false;
        }
        $.get("/sale/search-product/"+slug, function (data) {
            $('#tableProduct tbody').empty();
            if(data.length > 0) {
                $.each(data, function (index, value) { 
                    var tr_list = '<tr>' +
                                    '<td>' + '<img src="' + assets(value.image) + '" width=100px/>' + '</td>' +
                                    '<td>' + value.name + '</td>' +
                                    '<td>' + convertToRupiah(value.price) + '</td>' +
                                    '<td>' + value.price + '</td>' +
                                    '<td>' + '<button type="button" class="btn btn-primary btn-add" data-id="'+ value.id +'"><i class="fa fa-plus"></i></button>' + '</td>' +
                                '</tr>';
                    
                    $('#tableProduct tbody').append(tr_list);
                });
            } else {
                var tr_list = '<tr><td colspan="5" class="text-center"><h3>Tidak ada data yang ditemukan...</h3></td></tr>';
                $('#tableProduct tbody').append(tr_list);
            }
        });
    });
});