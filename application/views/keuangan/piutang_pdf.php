<style type="text/css">
	h3{
		text-align: center;
	}
</style>
<h3>Data Piutang</h3>
<h3>KPRI Rukun Makmur</h3>
<h3>Periode <?php echo date('Y')?></h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F">
		<th>Kode Penjualan</th>
		<th>Tanggal Penjualan</th>
		<th>Telah Dibayar</th>
		<th>Jumlah Transaksi</th>
		<th>Nama Anggota</th>
	</tr>
		<?php
			foreach($piutang as $data){?>
				<tr>
					<td><?php echo $data->id_penjualan?></td>
					<td><?php echo $data->tgl_trans?></td>
					<td><?php echo format_rp($data->jumlah_angsuran)?></td>
					<td><?php echo format_rp($data->jml_trans)?></td>
					<td><?php echo $data->nama?></td>
				</tr>
		<?php
			}
		?>
	
</table>