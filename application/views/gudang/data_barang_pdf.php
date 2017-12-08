	<h3 align="center">Data barang Pertokoan</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
	<h5 align="center">Per Tanggal <?php echo date('d-m-Y')?></h5>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th width="60" >ID Barang</th>
		<th>Nama Barang</th>
		<th>Harga Beli</th>
		<th>Harga Jual</th>
		<th>Jenis Barang</th>
		<th>Stok</th>
	</tr>
	<?php
		foreach ($barang as $data){?>
			<tr>
				<td><?php echo $data->id_barang?></td>
				<td><?php echo $data->nama_barang?></td>
				<td><?php echo format_rp($data->harga_beli)?></td>
				<td><?php echo format_rp($data->harga_jual)?></td>
				<td><?php 
					if ($data->kategori == 'KLT'){
						echo "Kelontong";
					}else{
						echo "Konsumsi";
					}
				?></td>
				<td><?php echo $data->stok?></td>
			</tr>
	<?php
		}
	?>
</table>