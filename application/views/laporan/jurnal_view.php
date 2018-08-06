<div class="row">
	<center><h1>Jurnal umum</h1></center>
</div>
<div class="row">
	<form method="POST" action="<?php base_url('index.php/Jurnal')?>">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="date" name="tgl_awal" class="form-control">
		</div>
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="date" name="tgl_akhir" class="form-control">
		</div>
		<div class="form-group">
			<input type="submit" name="btnsubmit" class="btn btn-primary" value="Cari">
		</div>
	</form>
</div>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-hover">
			<tr>
				<th>Tanggal</th>
				<th>Rekening</th>
				<th>Ref</th>
				<th>Debet</th>
				<th>Kredit</th>
			</tr>
			<?php
				foreach ($jurnal as $data){?>
					<tr>
						<td><?php echo $data->tgl_jurnal?></td>
						<?php
							if ($data->posisi_dr_cr == 'd'){?>
								<td><?php echo $data->nama_akun?></td>
						<?php		
							}else{?>
								<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $data->nama_akun?></td>
						<?php
							}
						?>
						<td><?php echo $data->no_akun?></td>
						<?php
							if ($data->posisi_dr_cr == 'd'){?>
								<td><?php echo format_rp($data->nominal)?></td>
								<td></td>
						<?php		
							}else{?>
								<td></td>
								<td><?php echo format_rp($data->nominal)?></td>
						<?php
							}
						?>
					</tr>
			<?php
				}
			?>
		</table>
	</div>
</div>