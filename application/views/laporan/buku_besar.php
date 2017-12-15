<style type="text/css">
	.judul{
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				Pilih Akun
			</div>
			<div class="card-body">
				<form class="form-inline">
					<div class="form-group">
						<select class="mx-sm-3 form-control" id="akun">
							<option disabled="" selected="">Pilih akun</option>
							<?php
								foreach($akun as $data){
									echo get_opt($data->no_akun,$data->nama_akun);
								}
							?>
						</select>	
					</div>
					<div class="form-group">
						<select class="mx-sm-3 form-control" id="bulan">
							<option selected="" disabled="">Bulan</option>
							<?php 
								for ($x = 1; $x <= 12; $x++) {?>
									<option value="<?php echo $x?>"><?php echo $x?></option>
							<?php
							}?>
						</select>
					</div>
					<div class="form-group"> 
						<select class="mx-sm-3 form-control" id="tahun">
							<option selected="" disabled="" >Tahun</option>
							<?php
								foreach($tahun as $data){?>
									<option value="<?php echo $data->tahun?>"><?php echo $data->tahun?></option>
							<?php
								}
							?>
						</select>
					</div>
					
				</form>
				<div class="form-group">
					<input type="submit" value="Submit" class="mx-sm-3 btn btn-primary" onclick="get_bukbesar()">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row" id="body_bukbes">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="judul">Buku Besar</h4>
				<h4 class="judul">KPRI Rukun Makmur</h4>
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered">
					<thead>
					<tr>
						<th rowspan="2"><center>No Akun</center></th>
						<th rowspan="2"><center>Nama Akun</center> </th>
						<th rowspan="2"><center>Debit</center></th>
						<th rowspan="2"><center>Kredit</center></th>
						<th colspan="2"><center>Saldo</center></th>
					</tr>
					<tr>
						<th><center>Debit</center></th>
						<th><center>Kredit</center></th>
					</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#body_bukbes").hide();
	});
	function get_bukbesar(){
		$("#body_bukbes").hide();
		$("tbody").empty();
		var bulan = $("#bulan").val();
		var akun = $("#akun").val();
		var tahun = $("#tahun").val(); 
		$.ajax({
			url:"<?php echo site_url('laporan/get_bukbesar/')?>"+akun+"/"+bulan+"/"+tahun,
			success:function(data){
				$("#body_bukbes").fadeIn();
				$("tbody").append(data);
			}
		});
	}
</script>