<div class="row">
	<div class="col-md-12">
		<h1>Gudang</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Tambah barang</div>
			<div class="panel-body">
				<!-- form -->
				<div class="col-md-6">
					<form action="<?php echo base_url('index.php/gudang/simpan_barang')?>" method="POST">
								<div class="form-group">
									<label>Nama barang</label>
									<input type="text" name="nama_barang" class="form-control">
								</div>
								<div class="form-group">
									<label>Jenis Barang</label>
									<select name="jenis_barang" class="form-control">
										<option value="" selected="">Pilih jenis</option>
										<option value="KLT">Kelontong</option>
										<option value="KSM">Konsumsi</option>
									</select>
								</div>
								<div class="form-group">
									<label>Harga Beli</label>
									<input type="text" name="harga_beli" class="form-control" onchange="hitung_harga(this.value)">
								</div>
								<div class="form-group">
									<label>Harga Jual</label>
									<input type="text" name="harga_jual" class="form-control" id="harga_jual"><small>Harga beli * 10%</small> 
								</div>
								<div class="form-group">
									<label>Stok</label>
									<input type="text" name="stok" class="form-control">
								</div>
								<div class="form-group">
									<button  class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
								</div>
					</form>
				</div>
				<!-- notification -->
				<div class="col-sm-6">
					<div class="form-group">
						<?php echo $notification?>
						<label></label>
						<?php echo form_error('nama_barang')?>
					</div>
					<div class="form-group">
						<?php echo form_error('jenis_barang')?>
					</div>
					<div class="form-group">
						<?php echo form_error('harga_beli')?>
					</div>
					<div class="form-group">
						<?php echo form_error('harga_jual')?>
					</div>
					<div class="form-group">
						<?php echo form_error('stok')?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function hitung_harga(harga_beli){
		var harga_dasar = parseInt(harga_beli);
		var keuntungan = harga_dasar* 0.1 + harga_dasar;
		document.getElementById("harga_jual").value = keuntungan;
	}
</script>