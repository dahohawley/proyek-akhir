<h3 align="center">Data Pemasok</h3>
<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<td>Nama Pemasok</td>
		<td>Alamat</td>
		<td>Telp</td>
	</tr>
	<?php
		foreach($supplier->result() as $data){?>
		<tr>
			<td><?php echo $data->nama_supplier?></td>
			<td><?php echo $data->alamat?></td>
			<td><?php echo $data->telp?></td>
		</tr>
	<?php
		}
	?>
</table>