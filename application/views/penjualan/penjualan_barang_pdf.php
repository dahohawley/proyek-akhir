	<h3 align="center">Laporan penjualan</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
	<h5 align="center">Per Tanggal <?php echo date('d-m-Y')?></h5>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Kode Penjualan</th>
		<th>Tanggal</th>
		<th>Jumlah</th>
		<th>Nama Supplier</th>
	</tr>
	<?php
		foreach ($pembelian as $data){?>
			<tr>
				<td><?php echo $data->id_pembelian?></td>
				<td><?php echo $data->tgl_trans?></td>
				<td><?php echo format_rp($data->jml_trans)?></td>
				<td><?php echo $data->nama_supplier?></td>
			</tr>
	<?php
		}
	?>
</table>