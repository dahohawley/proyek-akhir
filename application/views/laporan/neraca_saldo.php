<style type="text/css">
	.judul{
		text-align: center;
	}
	th{
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="judul">Neraca Saldo</h4>
				<h4 class="judul">KPRI RUkun Makmur</h4>
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered">
					<thead>
					<tr>
						<th>No Akun</th>
						<th>Nama Akun</th>
						<th>Debit</th>
						<th>Kredit</th>
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
		$.ajax({
			url:"<?php echo base_url('index.php/laporan/get_neraca_saldo')?>",
			success:function(data){
				$("tbody").append(data);
			}

		})
	})
</script>