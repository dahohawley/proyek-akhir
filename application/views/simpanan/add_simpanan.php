<div class="row bg-white has-shadow" id="content">
				<div class="col-md-12">
					<form id="form" action="<?php echo base_url('index.php/Simpanan/selesai')?>" method="POST">
						<div class="form-group">
                            <br>
							<label>Nama Anggota</label>
							<div class="form-group">
								<input type="hidden" name="id_simpanan" value="<?php echo $id_simpanan?>">
								<select name="no_anggota" class="form-control" id="no_anggota" placeholder="Pilih Anggota" onchange="get_simpanan_angg(this.value)">
                                <option disabled selected="">Pilih Anggota</option>
                                <?php
                                    foreach ($anggota as $data) {?>
                                      <option value="<?php echo $data->no_anggota?>"><?php echo $data->nama?></option> 
                                 <?php } 
                                ?>                        
                                </select>
                             
							</div> 
                            <label>Simpanan</label>
                            <div class="form-group">
                                <select name="id_jenis" class="form-control" id="id_jenis" onchange="get_tarif()">
                                    <option disabled="" selected="">Pilih Simpanan</option>
                                </select>
                              
                            </div>
                            <label>Tarif</label>
                            <div class="form-group">
                                <input name="tarif" class="form-control" id="tarif" readonly="">
                            </div>
                            <label>Tahun</label>
                            <div class="form-group">
                                <input name="tahun" class="form-control" id="tahun" onchange="get_periode()">
                            </div>
                            <label>Periode</label>
                            <div class="form-group">
                                <!--<input type="text" name="periode" id="periode" class="form-control" hidden="">-->
                                <input type="text" name="periode" id="periode" class="form-control" readonly="">
                            </div>
                            <!--<label>Periode</label>
                            <div class="form-group">
                                <select name="periode" class="form-control" id="periode">
                                    
                                </select>
                            </div>-->
							<input type="submit" class="btn btn-primary" value="Simpan">
						</div>
					</form>
				</div>	
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- ajax -->
<script type="text/javascript">
    function get_simpanan_angg(no_anggota){
        $.ajax({
            url: "<?php echo base_url('index.php/simpanan/get_simpanan_angg/')?>"+no_anggota,
            type: "GET",
            success: function(data){
                $("#tarif").val("");
                $("#id_jenis").html("");
                $("#id_jenis").append('<option disabled="" selected="">Pilih Simpanan</option>');
                $("#id_jenis").append(data);
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
                /*$("#periode").append('<option disabled="" selected="">Pilih Periode</option>');*/
                $("#periode").val(data);
            }
        })

    }
</script>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>
<script type="text/javascript">
</script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    var yyyy = (new Date()).getFullYear();
    $("#form" ).validate({
      rules: {
        no_anggota: "required",
        id_jenis: {
            required : true
        },
        tahun : {
            required : true,
            digits : true,
            minlength : 4,
            maxlength : 4,
            min : yyyy,
            max : yyyy
        },
        periode : "required"
      },
      messages:{
        no_anggota : "Nama Anggota tidak boleh kosong.",
        id_jenis: {
            required: "Simpanan tidak boleh kosong."
        },
        tahun : {
            required : "Tahun tidak boleh kosong.",
            digits : "Tahun hanya berisi angka bulat positif.",
            minlength : "Tahun tidak boleh kurang dari 4 karakter.",
            maxlength : "Tahun tidak boleh lebih dari 4 karakter.",
            min : "Tahun tidak boleh kurang dari tahun sekarang.",
            max : "Tahun tidak boleh lebih dari tahun sekarang."
        },
        periode : "Periode tidak boleh kosong."
      }
    });
})
</script>
