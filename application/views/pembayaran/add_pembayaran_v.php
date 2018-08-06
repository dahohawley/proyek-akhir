<div class="row bg-white has-shadow" id="content">
				<div class="col-md-12">
					<form id="form" action="<?php echo base_url('index.php/pembayaran/selesai')?>" method="POST">
						<div class="form-group">
                            <br>
							<label>Nama Beban</label>
							<div class="form-group">
								<input type="hidden" name="id_bayar" value="<?php echo $id_bayar?>">
								<select name="no_akun" class="form-control" id="no_akun">
                                    <option selected="" disabled="">Pilih Beban</option>
                                    <?php
                                        foreach($akun as $data){?>
                                            <option value="<?php echo $data->no_akun?>"><?php echo $data->nama_akun?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
							</div> 
						</div>
                        <div class="form-group">
                            <br>
                            <label>Nomor Bukti Pembayaran</label>
                            <div class="form-group">
                                <input type="text" name="no_bukti" class="form-control" id="no_bukti" required="">
                            </div> 
                        </div>
                         <div class="form-group">
                            <br>
                            <label>Tanggal Pembayaran</label>
                            <div class="form-group">
                                <input type="date" name="tgl_bayar" class="form-control" id="tgl_bayar" required="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <br>
                            <label>Total</label>
                            <div class="form-group">
                                <input type="text" name="total" class="form-control" id="total" required="">
                            </div> 
                            <button class="btn btn-success" id="btnSave">Selesai</button>
                        </div>
					</form>
				</div>	
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- ajax -->
<script type="text/javascript">
	function save(){
            $('#btnSave').text('Menambahkan.....'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('pembayaran/selesai')?>",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $("#no_akun").val("");
                        $("#no_akun").focus();
                        $("#table").load( "<?php echo base_url('index.php/pembayaran/TambahBayar')?> #table" );
                    }
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                },
                error: function (jqXHR, textStatus, errorThrown){
                    $("#no_akun").val("");
                    $("#no_akun").focus();
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $.notify({
                            // options
                            tittle: 'ID Beban tidak ditemukan',
                            icon: 'fa fa-warning',
                            message: 'ID Beban tidak ditemukan<br />' 
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
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('transaksi/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {		
                    $('[name="id_detail_pembayaran"]').val(data.id_detail_pembayaran);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('#no_akun_edit').val(data.no_akun);
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
    function selesai_belanja(){
    	$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    	$('.modal-title').text('Selesai'); // Set title to Bootstrap modal title
    	var total_table = $('#total_table').text();
    	$('#total_modal').val(total_table);
    }
</script>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>
<script type="text/javascript">
    $(function(){
        $("#form").validate({
          rules: {
            no_akun : "required",
            no_bukti:{
            	required:true,
            	minlength : 5,
                maxlength : 30
            },
            total : {
                required : true,
                maxlength : 11,
                digits : true,
                min : 1
            },
            tgl_bayar : {
                required : true,
                min : 1/1/2000,
                max : 12/31/2999 
            },
          },
          messages:{
            no_akun:"Nama Beban tidak boleh kosong.",
            no_bukti: {
                required: "Nomor Bukti tidak boleh kosong.",
                minlength : "Nomor Bukti minimal 5 karakter.",
                maxlength : "Nomor Bukti maksimal 30 karakter."
            },
            total : {
                required : "Total tidak boleh kosong.",
                maxlength : "Total tidak boleh lebih dari 11 karakter.",
                digits : "Total hanya berisi angka bulat positif.",
                min : "Total harus lebih dari 0."
            },
            tgl_bayar : {
                required : "Tanggal tidak boleh kosong.",
                min : "Tanggal tidak boleh kurang dari 1 Januari 2000.",
                max : "Tanggal tidak boleh lebih dari 31 Desember 2999."
          }
        });
    })
</script>
