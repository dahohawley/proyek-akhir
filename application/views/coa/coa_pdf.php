<center>
	<h3>Data Chart of Accounts(COA)</h3>
	<h3>KPRI Rukun Makmur</h3>
</center>
<table border="1" style="margin: 0;" width="100%">
	<tr style="background-color:#F4D03F ">
		<td>Kode Akun</td>
		<td>Nama Akun</td>
		<td>Saldo</td>
	</tr>
	<?php
		foreach($coa as $data){?>
			<tr>
				<td><?php echo $data->no_akun?></td>
				<td><?php echo $data->nama_akun?></td>
				<td><?php echo format_rp($data->saldo)?></td>
			</tr>
	<?php
		}
	?>
</table>