<div class="row bg-white has-shadow">
				<div class="col-md-12">
					<form id="form" action="#" >
						<div class="form-group">
                            <br>
							<label>Kode Barang</label>
							<div class="form-group">
								<input type="hidden" name="id_penjualan" value="<?php echo $no_trans?>">
								<input type="text" name="id_barang" class="form-control" id="id_barang" required="">
							</div> 
							<button class="btn btn-primary" id="btnSave" onclick="save()">Tambah</button>
						</div>
					</form>
				</div>	
			
				<div class="col-md-12">
					<h3>Keranjang</h3>
					<br>
					<div class="alert alert-danger" id="delete_message" style="display: none;">Data berhasil dihapus</div>
					<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			            <thead>
			                <tr>
			                    <th>Nama Barang</th>
			                    <th>Jumlah</th>
			                    <th>Harga satuan</th>
			                    <th>subtotal</th>
			                    <th colspan="2" align=""><center>Action</center></th>
			                </tr>
			            </thead>
			            <tbody>
			            	<?php
			            		foreach ($detail_penjualan->result() as $data){?>
									<tr>
										<td><?php echo $data->nama_barang?></td>
										<td><?php echo $data->jumlah?></td>
										<td><?php echo format_rp($data->harga_jual)?></td>
										<td><?php echo format_rp($data->subtotal)?></td>
										<td width="80"><button class="btn btn-info" onclick="edit_jumlah(<?php echo $data->id_penjualan?>)">Edit</button></td>
										<td width="80"><button class="btn btn-danger" onclick="hapus_barang(<?php echo $data->id_penjualan?>)">Hapus</button></td>
									</tr>
							<?php
			            		}
			            	?>
			            </tbody>
			        </table>
				</div>	
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn btn-info">Selesai belanja</button>
					</div>
				</div>
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script type="text/javascript">
	function save(){
            $('#btnSave').text('Menambahkan.....'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('transaksi/ajax_add')?>",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $("#id_barang").val("");
                        $("#id_barang").focus();
                        $("#table").load( "<?php echo base_url('index.php/transaksi/')?> #table" );
                    }
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 


                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Kode Barang tidak ditemukan');
                    $("#id_barang").val("");
                    $("#id_barang").focus();
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
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
                    $('[name="id_detail_penjualan"]').val(data.id_detail_penjualan);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('#id_barang_edit').val(data.id_barang);
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
	function hapus_barang(id){
            if(confirm('Hapus data ini?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('transaksi/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $("#delete_message").fadeIn();
                        $("#delete_message").delay(1200).fadeOut();
                        $('#modal_form').modal('hide');
                        $("#table").load( "<?php echo base_url('index.php/transaksi/')?> #table" );
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }
</script>
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Barang</h3>
            </div>
            <div class="modal-body form">
                <form id="form_edit" action="#" class="form-horizontal">
                    <input type="hidden" value="" id="id_detail_penjualan" name="id_detail_penjualan"/> 
                    <input type="hidden" value="" id="id_barang_edit" name="id_barang"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                                <input name="jumlah" id="jumlah"  placeholder="jumlah" class="form-control" type="text" required="">
                                <i id="nama_barang_message"></i>
                            </div>
                    </div>   
                </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script type="text/javascript">
	$(function(){
		$("#delete_message").hide();
		$("#form_edit" ).validate({
		  rules: {
		    jumlah: {
		    	required: true,
		    	number: true
		    }
		  },
		  messages:{
		  	jumlah:{
		  		required: "Jumlah tidak boleh kosong.",
		  		number: "Jumlah hanya dapat diisi dengan angka."
		  	}
		  },
		  submitHandler: function(form) {
		    save_edit();
		  }
		});
	})
</script>