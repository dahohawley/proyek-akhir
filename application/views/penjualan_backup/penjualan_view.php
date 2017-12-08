<div class="row bg-white has-shadow">
				<div class="col-md-10">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <br>
                        <br>
                        <button class="btn btn-info btn-lg" onclick="CariBarang()">Cari barang</button>
                    </div>
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
                            $total = 0;
			            		foreach ($detail_penjualan->result() as $data){
                                    $total = $total+$data->subtotal;?>
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
                        <tfoot>
                    <tr style="background-color: rgb(200, 247, 197);">
                        <td colspan="3"><b>TOTAL</b></td>
                        <td colspan="3" id="total_table">
                            <?php echo format_rp($total);?>
                        </td>
                    </tr>
                </tfoot>
			        </table>
				</div>	
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn btn-info" onclick="selesai_penjualan()">Selesai belanja</button>
					</div>
				</div>
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script type="text/javascript">
    function pilihBarang(id){
                $("#id_barang").val(id);
                $('#barang_modal').modal('hide'); // show bootstrap modal when complete loaded
                save();
            }
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
                        $("#table").load( "<?php echo base_url('index.php/transaksi/tambah_penjualan')?> #table" );
                    }
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 


                },
                error: function (jqXHR, textStatus, errorThrown){
                    $("#id_barang").val("");
                    $("#id_barang").focus();
                    $('#btnSave').text('Tambah'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable
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
                        $("#table").load( "<?php echo base_url('index.php/transaksi/tambah_penjualan')?> #table" );
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
    function selesai_penjualan(){
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Selesai Penjualan'); // Set title to Bootstrap modal title
        var total_table = $('#total_table').text();
        $('#total_modal').val(total_table);
    }
</script>
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
            <form action="<?php echo base_url('index.php/transaksi/selesai_penjualan')?>" method="POST" id="form2">
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="id_penjualan" value="<?php echo $no_trans?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Anggota</label>
                    <select class="form-control" name="id_anggota">
                    <?php
                        foreach($anggota as $data){
                            echo get_opt($data->no_anggota,$data->nama);
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total yang harus dibayar</label>
                    <input type="text" id="total_modal" name="total" class="form-control" value="" readonly>
                </div>
                <div class="form-group">
                    <label>Total bayar</label>
                    <input type="text" name="total_bayar" id="total_bayar" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="btnsubmit" class="btn btn-primary" value="Selesai">
                </div>
            </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="barang_modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table id="table_barang" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="80">Kode Barang</th>
                                    <th width="180">Nama Barang</th>
                                    <th width="80">Harga Beli</th>
                                    <th width="80">Harga Jual</th>
                                    <th width="80">Stok</th>
                                    <th style="width:125px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
</div>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
                table = $('#table_barang').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('transaksi/daftar_barang')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [{
                        "targets": [-1], //last column
                        "orderable": false, //set not orderable
                    }, ],

                });
            });
    function CariBarang() {
        $('#barang_modal').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Cari Barang'); // Set title to Bootstrap modal title
    }
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