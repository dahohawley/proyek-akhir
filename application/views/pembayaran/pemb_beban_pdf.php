	<h3 align="center">Daftar Pembayaran Beban</h3>
	<h3 align="center">KPRI Rukun Makmur</h3>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<th>Kode Pembayaran</th>
		<th>Tanggal Pembayaran</th>
        <th>Nomor Bukti Pembayaran</th>    
        <th>Nama Beban</th>
        <th>Jumlah Pembayaran</th>
	</tr>
	<?php
		foreach($list->result() as $data){?>
			<tr>
				<td><?php echo $data->id_bayar?></td>
				<td><?php echo $data->tgl_bayar?></td>
				<td><?php echo $data->no_bukti?></td>
				<td><?php echo $data->nama_akun?></td>
				<td><?php echo format_rp($data->jml_bayar)?></td>
			</tr>
	<?php
		}
	?>
</table>