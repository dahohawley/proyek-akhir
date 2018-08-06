	<h3 align="center">Daftar Transaksi Simpanan</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Kode Simpanan</th>
		<th>Tanggal Simpan</th>
		<th>Jumlah Simpan</th>
		<th>Nomor Anggota</th>
		<th>Jenis Simpanan</th>
		<th>Periode</th>
	</tr>
	<?php
		foreach($list->result() as $data){?>
			<tr>
				<td><?php echo $data->id_simpanan?></td>
				<td><?php echo $data->tgl_simpan?></td>
				<td><?php echo format_rp($data->jml_simpanan)?></td>
				<td><?php echo $data->no_anggota?></td>
				<td><?php echo $data->keterangan?></td>
				<td><?php echo get_monthname($data->periode)." ".$data->tahun?></td>
			</tr>
	<?php
		}
	?>
</table>