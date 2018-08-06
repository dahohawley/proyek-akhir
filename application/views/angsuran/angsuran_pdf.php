	<h3 align="center">Daftar Angsuran Anggota</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Kode Angsuran</th>
        <th>Kode Pinjaman</th>
        <th>Tanggal Angsuran</th>
        <th>Nomor Anggota</th>
        <th>Jumlah Angsuran</th>
        <th>Periode</th>
	</tr>
	<?php
		foreach($list->result() as $data){?>
			<tr>
				<td><?php echo $data->id_angsuran?></td>
				<td><?php echo $data->id_pinjam?></td>
				<td><?php echo $data->tgl_angsur?></td>
				<td><?php echo $data->no_anggota?></td>
				<td><?php echo format_rp($data->jml_angsur)?></td>
				<td><?php echo get_monthname($data->periode)." ".$data->tahun?></td>
			</tr>
	<?php
		}
	?>
</table>