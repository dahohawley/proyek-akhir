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
										<td width="80"><button class="btn btn-info" onclick="edit_jumlah('<?php echo $data->id_penjualan?>','<?php echo $data->id_barang?>')">Edit</button></td>
										<td width="80"><button class="btn btn-danger" onclick="hapus_barang('<?php echo $data->id_penjualan?>','<?php echo $data->id_barang?>')">Hapus</button></td>
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
                        <input type="hidden" name="total_table2" id="total_table2" value="<?php echo $total?>">
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
    var base_url = "<?php echo base_url()?>";
    var sisa_stok = 0;
</script>
<script src="<?php echo base_url('assets/js/penjualan_script.js')?>"></script>
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
                    <select class="form-control" name="id_anggota" id="id_anggota">
                        <option selected disabled value>Pilih Anggota</option>
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
                    <input type="hidden" id="total_modal2" value="" name="total_modal2">
                </div>
                <div class="form-group">
                    <label>Total bayar</label>
                    <input type="text" name="total_bayar" id="total_bayar" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="btnsubmit" id="btnForm" class="btn btn-primary" value="Selesai">
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
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Perbarui Jumlah</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form action="#" class="form-control" id="form_detail">
                <input type="hidden" name="harga">
                <input type="hidden" name="id_penjualan">
                <input type="hidden" name="id_barang_modal">
                <input type="hidden" name="sisa_stok">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" name="jumlah" class="form-control" id="jumlah">
                </div>
                <div class="form-group">
                    <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>