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
		<th>Kode Pembelian</th>
		<th>Tanggal Pembelian</th>
		<th>Telah Dibayar</th>
		<th>Jumlah Transaksi</th>
		<th>Nama Pemasok</th>
	</tr>
		<?php
			foreach($utang as $data){?>
				<tr>
					<td><?php echo $data->id_pembelian?></td>
					<td><?php echo $data->tanggal?></td>
					<td><?php echo format_rp($data->jumlah_angsuran)?></td>
					<td><?php echo format_rp($data->jml_trans)?></td>
					<td><?php echo $data->nama_supplier?></td>
				</tr>
		<?php
			}
		?>
	
</table>