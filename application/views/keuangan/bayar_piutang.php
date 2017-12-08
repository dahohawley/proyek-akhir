<div class="card">
	<div class="card-header">
		<h4>Form Piutang</h4>
	</div>
	<div class="card-body">
	    <form action="<?php echo base_url('index.php/keuangan/bayarkan_piutang/'.$id_penjualan)?>" method="POST" id="form-pembayaran">
		    <div class="form-group">
				<label>Kode Penjualan</label>
				<input type="text" name="id_penjualan" value="<?php echo $id_penjualan?>" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Sisa Piutang</label>
				<input type="text" name="sisa_piutang" value="<?php echo format_rp($detail->jml_trans - $detail->telah_dibayar)?>" readonly="" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah Bayar</label>
				<input type="text" name="jumlah_bayar" class="form-control">
			</div>
			<div class="form-group">
				<button class="btn btn-primary">Bayar</button>
			</div>
	    </form>
	</div>
</div>
<script type="text/javascript">
	$( "#form-pembayaran" ).validate({
	  rules: {
	    jumlah_bayar: {
	      required: true,
	      number: true,
	      max: <?php echo $detail->jml_trans - $detail->telah_dibayar?>
	    }
	  },
	  messages:{
	  	jumlah_bayar:{
	  		required: "Jumlah bayar tidak boleh kosong.",
	  		number: "Jumlah bayar hanya dapat diisi oleh angka 0-9",
	  		max: "Tidak dapat membayar piutang lebih dari sisa piutang"	

	  	}
	  }
	});
</script>

              