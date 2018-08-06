<div class="row bg-white has-shadow" id="content">
				<div class="col-md-12">
                    <form id="form">
						<div class="form-group">
                            <br>
                            <div class="form-group">
							<label>Nama Anggota</label>
								<input type="hidden" name="id_penarikan" id="id_penarikan" value="<?php echo $id_penarikan?>">
                                <input type="hidden" name="no_anggota" id="no_anggota" value="<?php echo $anggota->no_anggota?>">
								<input type="text" id="nama" class="form-control" value="<?php echo $anggota->nama?>" readonly="">
							</div> 
                             <div class="form-group">
                            <label>Keperluan Penarikan</label>
                               <select name="tipe" id="tipe" class="form-control" onchange="tampil_simpanan()">
                                    <option value="" disabled selected="">Pilih Tipe</option>
                                    <option value="1">Keluar Keanggotaan</option>
                                    <option value="2">Hari Raya</option>
                                    <option value="3">Pendidikan</option>
                                    <option value="4">Manasuka</option>
                               </select>
                            </div> 
                        </div>
                    </form>	
                </div>
</div>
<div class="row bg-white has-shadow">
    <div class="col-md-12">
    <table class="table table-hover" id="tabel_simpanan">
        <thead>
        <tr>
            <th>Nama Simpanan</th>
            <th>Jumlah Simpanan</th>
        </tr>
        </thead> 
        <tbody>
          
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <form id="form2">
              <div class="form-group">
                            <label>Nominal</label>
                                <input name="nominal" class="form-control" id="nominal" class="form-control">
                            </div></form>
                <button class="btn btn-primary" onclick="tarik()" id="btnsimpan">Tarik</button> 
                </td>
            </tr>
        </tfoot>
    </table>
    </div>

</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- ajax -->
<script type="text/javascript">
    var total_simpanan = 0;
    $(document).ready(function(){
        $("#tabel_simpanan").hide();
    })
    function tampil_simpanan(no_anggota){
        var no_anggota = $("#no_anggota").val();
        var tipe = $("#tipe").val();
        $("#btnsimpan").removeAttr('disabled');
         $.ajax({
            url: "<?php echo base_url('index.php/Penarikan/tampil_simpanan/')?>"+no_anggota+"/"+tipe,
            type:"GET",
            success: function(data){
                data2 = data.split('|');
                $("#tabel_simpanan").fadeIn("slow");
                $("tbody").empty();
                $("tbody").append(data2[0]);
                total_simpanan = data2[1]*1; 
                if(data2[1] == ' FALSE'){
                    console.log('false');
                    $("#btnsimpan").attr('disabled','true');
                }else{
                    console.log('true');
                    total = data2[1];
                }
            }
       })
    }
    function tarik(){
        var tipe = $("#tipe").val();
        var no_anggota = $("#no_anggota").val();
        var id_penarikan = $("#id_penarikan").val();
        $.ajax({
            type: "POST",
            data: $('#form2').serialize(),
            dataType: "JSON",
            url:"<?php echo base_url('index.php/Penarikan/tarik_simpanan/')?>"+no_anggota+"/"+tipe+"/"+id_penarikan
        });
       $(location).attr('href', '<?php echo base_url('index.php/Penarikan')?>');
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
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    var yyyy = today.getFullYear();
    $("#nominal" ).validate({
      rules: {
        nominal : {
            required : true,
            digits : true,
            maxlength : 11,
            min : 1
        },
      },
      messages:{
        nominal: {
            required: "Nominal tidak boleh kosong.",
            digits : "Nominal hanya berisi angka bulat positif.",
            maxlength : "Nominal tidak boleh lebih dari 11 karakter.",
            min : "Nominal harus lebih dari 0."
        }
      }
    });
})
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#nominal").on('change',function(){
            var nominal = $("#nominal").val();
            if(nominal < 1000){
                $.notify({
                // options
                tittle: '',
                icon: 'fa fa-warning',
                message: 'Nominal tidak boleh kurang dari Rp 1.000,-.<br />' 
            },{
                // settings
                placement:{
                align:'center'
                },
                delay: "20",
                type: 'danger'
            }); 
            $("#btnsimpan").attr('disabled','true');
            }else if(nominal.length > 11) {
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
            }else if(nominal == null){
                $.notify({
                    // options
                    tittle: '',
                    icon: 'fa fa-warning',
                    message: 'Nominal harus diisi.<br />' 
                },{
                    // settings
                    placement:{
                    align:'center'
                    },
                    delay: "20",
                    type: 'danger'
                }); 
               $("#btnsimpan").attr('disabled','true');
            }else if(nominal > total_simpanan){
                 $.notify({
                    // options
                    tittle: '',
                    icon: 'fa fa-warning',
                    message: 'Nominal tidak bisa lebih dari jumlah simpanan<br />' 
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
    })
</script>
