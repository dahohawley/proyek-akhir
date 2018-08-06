	<h3 align="center">Daftar Anggota</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Nomor Anggota</th>
		<th>Nama Anggota</th>
		<th>Alamat</th>
		<th>Status</th>
	</tr>
	<?php
		foreach($anggota->result() as $data){?>
			<tr>
				<td><?php echo $data->no_anggota?></td>
				<td><?php echo $data->nama?></td>
				<td><?php echo $data->alamat?></td>
				<td><?php 
					if ($data->status == '1'){
						echo "Pegawai";
					}elseif ($data->status == '2') {
						echo "Pensiun";
					}else{
						echo "Mutasi";
					}
				?></td>
			</tr>
	<?php
		}
	?>
</table>