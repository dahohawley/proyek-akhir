<style type="text/css">
	.judul{
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="judul">Laporan Arus Kas</h4>
				<h4 class="judul">KPRI Rukun Makmur</h4>
				<h5 class="judul">Periode <?php echo date('Y')?></h5>
			</div>
			<div class="card-body">
				<table class="table table-hover table table-bordered">
				  <tr>
				    <th colspan="3">Aktifitas Operasional</th>
				  </tr>
				  <tr>
				    <td>Penjualan</td>
				    <td><?php echo format_rp($penjualan)?></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Return Pembelian</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembelian Persediaan Barang</td>
				    <td>(<?php echo format_rp($pembelian)?>)</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Total Biaya &amp; Beban</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembayaran Pajak Usaha</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktifitas Operasional</td>
				    <td></td>
				    <td><?php echo format_rp($penjualan-$pembelian)?></td>
				  </tr>
				</table>
			</div>
		</div>
	</div>
</div>