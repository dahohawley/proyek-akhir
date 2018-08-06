 function save() {
     $('#btnSave').text('Menambahkan.....'); //change button text
     $('#btnSave').attr('disabled', true); //set button disable
     // ajax adding data to database
     $.ajax({
         url: baseURL + "index.php/pembelian/tambah_detail",
         type: "POST",
         data: $('#form').serialize(),
         dataType: "JSON",
         success: function(data) {
             if (data.status) //if success close modal and reload ajax table
             {
                 $("#id_barang").val("");
                 $("#id_barang").focus();
                 $("#table").load(baseURL + "index.php/pembelian/tambah_pembelian #table");
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

 function pilihBarang(id) {
     $("#id_barang").val(id);
     $('#barang_modal').modal('hide'); // show bootstrap modal when complete loaded
     save();
 }
 function hapus_barang(id_pembelian, id_barang) {
     if (confirm('Hapus data ini?')) {
         // ajax delete data to database
         $.ajax({
             url: baseURL + "index.php/pembelian/delete_detail/" + id_pembelian + "/" + id_barang,
             type: "POST",
             dataType: "JSON",
             success: function(data) {
                 //if success reload ajax table
                 $('#modal_form').modal('hide');
                 $("#table").load(baseURL + "/index.php/pembelian/tambah_pembelian #table");
                 $.notify({
                     // options
                     tittle: 'Hapus detail barang',
                     icon: 'fa fa-check',
                     message: 'Data berhasil dihapus<br />'
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
                 alert('Error deleting data');
             }
         });

     }
 }

 function selesai_belanja() {
     var total_table2 = $("#total_table2").val();

     $('[name="total_bayar"]').rules('add', {
         required: true,
         number: true,
         max: total_table2,
         messages: {
             required: "Jumlah tidak boleh kosong.",
             number: "Jumlah hanya dapat diisi dengan angka.",
             max: "Tidak bisa melebihi total transaksi"
         },
     });
     if(total_table2 == 0){
        $.notify({
            // options
            tittle: 'Masukkan Barang Terlebih Dahulu.',
            icon: 'fa fa-exclamation-triangle',
            message: 'Masukkan barang terlebih dahulu'
        }, {
            // settings
            placement: {
                align: 'center'
            },
            delay: "20",
            type: 'danger'
        });
     }else{
        var total_table = $('#total_table').text();
         $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
         $('.modal-title').text('Selesai belanja'); // Set title to Bootstrap modal title
         $('#total_modal').val(total_table);
     }
 }
 $(document).ready(function() {
     table = $('#table_barang').DataTable({

         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
             "url": baseURL+"index.php/pembelian/daftar_barang",
             "type": "POST"
         },

         //Set column definition initialisation properties.
         "columnDefs": [{
             "targets": [-1], //last column
             "orderable": false, //set not orderable
         }, ],

     });
     $("#cariBarang").click(function(event){
        event.preventDefault();
        $('#barang_modal').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Cari Barang'); // Set title to Bootstrap modal title

     })
 });
 // function CariBarang() {
 //     $('#barang_modal').modal('show'); // show bootstrap modal when complete loaded
 //     $('.modal-title').text('Cari Barang'); // Set title to Bootstrap modal title
 // }
 //validate form
 $(function() {
     $("#form2").validate({
         rules: {
             total_bayar: {
                 required: true,
                 number: "true",
                 min: 1
             },
             supplier: "required",
         },
         messages: {
             supplier: "Supplier tidak boleh kosong.",
             total_bayar: {
                 required: "Total bayar tidak boleh kosong.",
                 number: "Total bayar hanya bisa diisi oleh angka.",
                 min : "Total Bayar tidak boleh kurang dari 1."
             },
         }
     });
     $("#form_detail").validate({
         rules: {
             jumlah: {
                 required: true,
                 number: "true",
                 min: 1
             }
         },
         messages: {
             jumlah: {
                 required: "Jumlah tidak boleh kosong.",
                 number: "Jumlah hanya bisa diisi oleh angka.",
                 min: "Tidak bisa kurang dari 1"
             },
         },
         submitHandler: function(form) {
            save_edit();
          }
     });
 })

function edit_barang(id_pembelian,id_barang){
    $.ajax({
        url: baseURL+"index.php/pembelian/detail_by_id/"+id_pembelian+"/"+id_barang,
        type:"GET",
        dataType: "JSON",
        success: function(data){
            $('label.error').hide()
            $('[name="nama_barang"]').val(data.nama_barang);
            $('[name="jumlah"]').val(data.jumlah);
            $('[name="id_pembelian"]').val(data.id_pembelian);
            $('[name="id_barang_modal"]').val(data.id_barang);
            $('#edit_jumlah').modal('show');
        }
    })
 }
 
function save_edit(){
    $.ajax({
         url: baseURL + "index.php/pembelian/edit_detail",
         type: "POST",
         data: $('#form_detail').serialize(),
         dataType: "JSON",
         success: function(data) {
             if (data.status) //if success close modal and reload ajax table
             {
                 $("#table").load(baseURL + "index.php/pembelian/tambah_pembelian #table");
                 $('#edit_jumlah').modal('hide');
             }
             $.notify({
                 // options
                 tittle: 'Berhasil dihapus',
                 icon: 'fa fa-check',
                 message: 'Data berhasil diubah<br />'
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
                 tittle: 'Terjadi kesalahan!',
                 icon: 'fa fa-warning',
                 message: 'Terjadi kesalahan saat mencoba perubahan.<br />'
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