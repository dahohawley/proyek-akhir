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
				<form>
					<select class="form-control" id="no_akun" onchange="get_bukbesar(this.value)">
						<option disabled="" selected="">Pilih akun</option>
						<?php
							foreach($akun as $data){
								echo get_opt($data->no_akun,$data->nama_akun);
							}
						?>
					</select>
				</form>
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
	function get_bukbesar(no_akun){
		$("#body_bukbes").hide();
		$("tbody").empty();
		$.ajax({
			url:"<?php echo site_url('laporan/get_bukbesar/')?>"+no_akun,
			success:function(data){
				$("#body_bukbes").fadeIn();
				$("tbody").append(data);
			}
		});
	}
</script>