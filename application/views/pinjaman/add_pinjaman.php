<div class="row bg-white has-shadow" id="content">
                <div class="col-md-12">
                    <form id="form" action="<?php echo base_url('index.php/Pinjaman/selesai')?>" method="POST">
                        <div class="form-group">
                            <br>
                            <div class="form-group">
                                <input type="hidden" name="id_pinjam" value="<?php echo $id_pinjam?>">
                                <label>Nama Anggota</label>
                                <input type="hidden" name="no_anggota" id="no_anggota" value="<?php echo $anggota->no_anggota?>">
                                <input type="text" id="nama" class="form-control" value="<?php echo $anggota->nama?>" readonly="">
                                <!--<select name="no_anggota" class="form-control" id="no_anggota" placeholder="Pilih Anggota">
                                <option disabled selected="">Pilih Anggota</option>
                                <?php
                                    foreach ($anggota as $data) {?>
                                      <option value="<?php echo $data->no_anggota?>"><?php echo $data->nama?></option> 
                                 <?php } 
                                ?>                        
                                </select>-->
                            </div> 
                            <div class="form-group">
                                 <label>Jumlah Pinjam</label>
                                <input name="jml_pinjam" class="form-control" id="jml_pinjam">
                            </div>
                            <div class="form-group">
                                <label>Banyak Angsuran</label>
                                <input name="banyak" class="form-control" id="banyak" onchange="get_jatuh_tempo()">
                            </div>
                            <div class="form-group">
                                <label>Bunga Perbulan (%)</label>
                                <input name="bunga" class="form-control" id="bunga" value="1.2" readonly="">
                            </div>
                            <div class="form-group">
                                <label>Angsuran Perbulan</label>
                                <input type="text" name="angsur" id="angsur" class="form-control" readonly>
                            </div>
                            <!--<div class="form-group">
                                <label>Jatuh Tempo</label>
                                <input type="text" name="jatuh_tempo" id="jatuh_tempo" class="form-control" readonly="" >
                            </div>-->
                            <input type="submit" class="btn btn-primary" value="Simpan" id="btnsimpan">
                        </div>
                    </form>
                </div>  
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    var yyyy = (new Date()).getFullYear();
    $("#form" ).validate({
      rules: {
        jml_pinjam : {
            required : true,
            digits : true,
            maxlength : 11,
            min : 1
        },
        banyak : {
            required : trued,
            digits : true,
            min : 1,
            max : 36
        }
      },
      messages:{
        jml_pinjam : {
            required : "Jumlah Pinjam tidak boleh kosong",
            digits : "Jumlah Pinjam hanya berisi angka",
            maxlength : "Jumlah Pinjam tidak boleh lebih dari 11 karakter",
            min : "Jumlah Pinjam harus lebih dari 0"
        },
        banyak : {
            required : "Banyak Angsuran tidak boleh kosong",
            digits : "Banyak Angsuran hanya berisi angka",
            min : "Banyak Angsuran minimal adalah 1 kali",
            max : "Banyak Angsuran maksimal adalah 36 kali"
      }
    });
})
</script>
<!-- ajax -->
<script type="text/javascript">
    $("#banyak").change(function(){
        var jumlah_pinjaman = $("#jml_pinjam").val();
        var banyak = $("#banyak").val();
        var bunga = $("#bunga").val();
        var angsuran_perbulan;
        if(jumlah_pinjaman < 1){
            $.notify({
                // options
                tittle: '',
                icon: 'fa fa-warning',
                message: 'Isi jumlah pinjaman terlebih dahulu.<br />' 
            },{
                // settings
                placement:{
                align:'center'
                },
                delay: "20",
                type: 'danger'
            });  
        }else{
            if(banyak < 1){
                $.notify({
                    // options
                    tittle: '',
                    icon: 'fa fa-warning',
                    message: 'Banyak angsuran tidak boleh kosong/nol.<br />' 
                },{
                    // settings
                    placement:{
                    align:'center'
                    },
                    delay: "20",
                    type: 'danger'
                });    
                $("#angsur").val("");
                $("#banyak").val("");
                $("#banyak").focus();
            }else if(banyak>36){
                $.notify({
                    // options
                    tittle: '',
                    icon: 'fa fa-warning',
                    message: 'Banyak angsuran tidak boleh lebih dari 36 kali.<br />' 
                },{
                    // settings
                    placement:{
                    align:'center'
                    },
                    delay: "20",
                    type: 'danger'
                });    
                $("#angsur").val("");
                $("#banyak").val("");
                $("#banyak").focus();
            }else{    
                angsuran_perbulan = (jumlah_pinjaman/banyak*bunga/100)+(jumlah_pinjaman/banyak);
                $("#angsur").val(Math.round(angsuran_perbulan));
            }
        }
    })
    $("#jml_pinjam").change(function(){
        var jumlah_pinjam = $("#jml_pinjam").val();
        //tidak boleh lebih dari 11 karakter
        if(jumlah_pinjam.length > 11){
             $.notify({
                // options
                tittle: '',
                icon: 'fa fa-warning',
                message: 'Tidak bisa lebih dari sebelas karakter.<br />' 
            },{
                // settings
                placement:{
                align:'center'
                },
                delay: "20",
                type: 'danger'
            }); 
            $("#btnsimpan").attr('disabled','true');
        }else if(isNaN(jumlah_pinjam) == true){
             $.notify({
                // options
                tittle: '',
                icon: 'fa fa-warning',
                message: 'Jumlah Pinjam diisi dengan angka.<br />' 
            },{
                // settings
                placement:{
                align:'center'
                },
                delay: "20",
                type: 'danger'
            }); 
            $("#btnsimpan").attr('disabled','true');
        }else if (jumlah_pinjam < 50000){
            $.notify({
                // options
                tittle: '',
                icon: 'fa fa-warning',
                message: 'Jumlah Pinjam minimal Rp 50.000,-.<br />' 
            },{
                // settings
                placement:{
                align:'center'
                },
                delay: "20",
                type: 'danger'
            }); 
            $("#btnsimpan").attr('disabled','true');
        }else{
            $("#btnsimpan").removeAttr('disabled');
        }
    })
   function get_angsur_perbulan(){
        $.ajax({
            url: "<?php echo base_url('index.php/Pinjaman/get_angsur_perbulan/')?>"+no_anggota,
            type: "GET",
            success: function(data){
                $("#tarif").val("");
                $("#id_jenis").html("");
                $("#id_jenis").append('<option disabled="" selected="">Pilih Simpanan</option>');
                $("#id_jenis").append(data);
            }
        })
    }
     function get_jatuh_tempo() {
         var banyak = $("#banyak").val();
         $.ajax({
             url: "<?php echo base_url('index.php/Pinjaman/get_jatuh_tempo/')?>" + banyak,
             type: "GET",
             success: function(data) {
                 $("#jatuh_tempo").val(data);
             }
         })
     }
    function get_tarif(){
       var no_anggota = $("#no_anggota").val();
       var jenis_simpanan = $("#id_jenis").val();
       $.ajax({
            url: "<?php echo base_url('index.php/simpanan/get_tarif/')?>"+no_anggota+"/"+jenis_simpanan,
            type:"GET",
            success: function(data){
                $("#tarif").val(data);
            }
       })
    }
    function save(){
            $('#btnSave').text('Menambahkan.....'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('Simpanan/selesai')?>",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $("#id_barang").val("");
                        $("#id_barang").focus();
                        $("#table").load( "<?php echo base_url('index.php/simpanan/tambah_simpanan')?> #table" );
                        get_simpanan_angg($("#no_anggota").val());
                    }
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $('#no_anggota').attr('disabled',true);
                },
                error: function (jqXHR, textStatus, errorThrown){
                    $("#id_barang").val("");
                    $("#id_barang").focus();
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $.notify({
                            // options
                            tittle: 'Kode Simpanan tidak ditemukan',
                            icon: 'fa fa-warning',
                            message: 'Kode Simpanan tidak ditemukan<br />' 
                        },{
                            // settings
                            placement:{
                                align:'center'
                            },
                            delay: "20",
                            type: 'danger'
                        }); 
                }
            });
    }
    function save_edit(){
            //$('#btnSave').text('Menambahkan.....'); //change button text
            //$('#btnSave').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('transaksi/ajax_edit_save')?>",
                type: "POST",
                data: $('#form_edit').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status) //if success close modal and reload ajax table
                    {
                        $("#table").load( "<?php echo base_url('index.php/transaksi/')?> #table" );
                    }
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $('#modal_form').modal('hide'); // show bootstrap modal when complete loaded

                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('error'); 
                }
            });
    }
    function edit_jumlah(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            //Ajax Load daa from ajax
            $.ajax({
                url : "<?php echo site_url('transaksi/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {       
                    $('[name="id_simpanan"]').val(data.id_simpanan);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('#id_barang_edit').val(data.id_jenis);
                    $('[name="jumlah"]').focus();
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Detail'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
    }
    function hapus_barang(id_simpanan,id_jenis){
            if(confirm('Hapus data ini?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('simpanan/delete_detail')?>/"+id_simpanan+"/"+id_jenis,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        $("#table").load( "<?php echo base_url('index.php/simpanan/tambah_simpanan/')?> #table" );
                        get_simpanan_angg($("#no_anggota").val());
                         $.notify({
                            // options
                            tittle: 'Hapus detail simpanan',
                            icon: 'fa fa-check',
                            message: 'Data berhasil dihapus<br />' 
                        },{
                            // settings
                            placement:{
                                align:'center'
                            },
                            delay: "20",
                            type: 'success'
                        }); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
    }
    function selesai_belanja(){
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Selesai'); // Set title to Bootstrap modal title
        var total_table = $('#total_table').text();
        $('#total_modal').val(total_table);
        $('#no_anggota_modal').val();
    }
    function get_periode(){
        var no_anggota = $("#no_anggota").val();
        var id_jenis = $("#id_jenis").val();
        var tahun = $("#tahun").val()
        $.ajax({
            url:"<?php echo base_url('index.php/simpanan/get_periode/')?>"+id_jenis+"/"+no_anggota+"/"+tahun,
            type:"GET",
            success:function(data){
                $("#periode").empty();
                $("#periode").append('<option disabled="" selected="">Pilih Periode</option>');
                $("#periode").append(data);
            }
        })

    }
</script>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>



