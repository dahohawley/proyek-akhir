	<h3 align="center">Daftar Pinjaman Anggota</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Kode Pinjaman</th>
        <th>Tanggal Pinjam</th>
        <th>Nomor Anggota</th>
        <th>Jumlah Pinjam</th>
        <th>Angsuran Perbulan</th>
        <th>Jatuh Tempo</th>
        <th>Status Pinjaman</th>
	</tr>
	<?php
		foreach($list->result() as $data){?>
			<tr>
				<td><?php echo $data->id_pinjam?></td>
				<td><?php echo $data->tgl_pencairan?></td>
				<td><?php echo $data->no_anggota?></td>
				<td><?php echo format_rp($data->jml_pinjam)?></td>
				<td><?php echo format_rp($data->tarif_angsur)?></td>
				<td><?php echo $data->jatuh_tempo?></td>
				<td><?php 
					if ($data->status == '2'){
						echo "Belum Lunas";
					}elseif ($data->status == '3') {
						echo "Lunas";
					}
				?></td>
			</tr>
	<?php
		}
	?>
</table>