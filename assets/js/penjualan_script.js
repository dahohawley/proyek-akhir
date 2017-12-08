function save_edit(){
    $.ajax({
        url: base_url + "index.php/transaksi/simpan_update",
        type: "POST",
        data: $('#form_detail').serialize(),
        dataType: "JSON",
        success: function(data) {
            $("#table").load(base_url+"index.php/transaksi/tambah_penjualan #table");
            $("#modal_detail").modal("hide");
            $.notify({
                // options
                tittle: 'Terjadi kesalahan',
                icon: 'fa fa-check',
                message: 'Barang berhasil dirubah.<br />'
            }, {
                // settings
                placement: {
                    align: 'center'
                },
                delay: "20",
                type: 'success'
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.notify({
                // options
                tittle: 'Terjadi kesalahan',
                icon: 'fa fa-warning',
                message: 'Terjadi kesalahan ketika merubah detail.<br />'
            }, {
                // settings
                placement: {
                    align: 'center'
                },
                delay: "20",
                type: 'danger'
            });
        }
    })
}

function pilihBarang(id) {
    $("#id_barang").val(id);
    $('#barang_modal').modal('hide'); // show bootstrap modal when complete loaded
    save();
}

function save() {
    $('#btnSave').text('Menambahkan.....'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    // ajax adding data to database
    $.ajax({
        url: base_url + "index.php/transaksi/ajax_add",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {

            if (data.status) //if success close modal and reload ajax table
            {
                $("#id_barang").val("");
                $("#id_barang").focus();
                $("#table").load(base_url+"index.php/transaksi/tambah_penjualan #table");
            }
            $('#btnSave').text('Tambah'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#id_barang").val("");
            $("#id_barang").focus();
            $('#btnSave').text('Tambah'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
            $.notify({
                // options
                tittle: 'Kode barang tidak ditemukan',
                icon: 'fa fa-warning',
                message: 'Kode barang tidak ditemukan<br />'
            }, {
                // settings
                placement: {
                    align: 'center'
                },
                delay: "20",
                type: 'danger'
            });
        }
    });
}

function hapus_barang(id_penjualan,id_barang) {
    if (confirm('Hapus data ini?')) {
        // ajax delete data to database
        $.ajax({
            url: base_url + "index.php/transaksi/ajax_delete/" + id_penjualan + "/" + id_barang,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $.notify({
                    // options
                    tittle: 'Kode barang tidak ditemukan',
                    icon: 'fa fa-check',
                    message: 'Barang berhasil terhapus.<br />'
                }, {
                    // settings
                    placement: {
                        align: 'center'
                    },
                    delay: "20",
                    type: 'success'
                });
                $("#table").load(base_url+"index.php/transaksi/tambah_penjualan #table");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });

    }
}

function selesai_penjualan() {
    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Selesai Penjualan'); // Set title to Bootstrap modal title
    var total_table = $('#total_table').text();
    var total_table2 = $('#total_table2').val();
    $('#total_modal').val(total_table);
}

function edit_jumlah(id_penjualan, id_barang) {
    $.ajax({
        url: base_url + "index.php/transaksi/get_by_id/" + id_penjualan + "/" + id_barang,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="harga"]').val(data.harga_jual);
            $('[name="id_penjualan"]').val(data.id_penjualan);
            $('[name="id_barang_modal"]').val(data.id_barang);
            $('[name="nama_barang"]').val(data.nama_barang);
            $('[name="jumlah"]').val(data.jumlah);
            $("#modal_detail").modal("show");
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    })
}
$(function() {
    $("#form_detail").validate({
        rules: {
            jumlah: {
                required: true,
                number: true
            }
        },
        messages: {
            jumlah: {
                required: "Jumlah tidak boleh kosong.",
                number: "Jumlah hanya dapat diisi dengan angka."
            }
        },
        submitHandler: function(form) {
            save_edit();
        }
    });
});

$(document).ready(function() {
    table = $('#table_barang').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "index.php/transaksi/daftar_barang",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        }, ],

    });
    $("#total_bayar").change(function(){
        $("#btnForm").prop('disabled',false);
        var total = $("#total_table2").val()*1;
        var total_bayar = $("#total_bayar").val()*1;
        console.log("TOTAL :"+total+" TOTAL BAYAR : "+total_bayar);
        if(total_bayar > total){
            $("#btnForm").prop('disabled',true);
            console.log("KELEBIHAN");
            $.notify("Tidak bisa membayar lebih dari total bayar");
        }
    })
});

function CariBarang() {
    $('#barang_modal').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Cari Barang'); // Set title to Bootstrap modal title
}
