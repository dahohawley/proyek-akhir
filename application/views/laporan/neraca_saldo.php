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
				Pilih Periode
			</div>
			<div class="card-body">
				<form class="form-inline">
					<div class="form-group">
						<select class="mx-sm-3 form-control" id="bulan">
							<option disabled="" selected="">Pilih Bulan</option>
							<?php
								for($i=1;$i<=12;$i++){?>
									<option value="<?php echo $i?>"><?php echo get_monthname($i)?></option>
							<?php
								}
							?>
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
					<input type="submit" value="Cari" class="mx-sm-3 btn btn-primary" id="btnCari">
					<button id="btnCetak" class="btn btn-success" onclick="printDiv()"><i class="fa fa-print"></i> Cetak PDF</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row" id="data-row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="judul">Neraca Saldo</h4>
				<h4 class="judul">KPRI RUkun Makmur</h4>
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered">
					<thead  style="text-align: center;">
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
		$("#data-row").hide();
		$("#btnCetak").hide();
	});
	$("#btnCari").click(function(){
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();
		$("#data-row").fadeOut();
		$("tbody").empty();
		$.ajax({
			url:"<?php echo site_url('Laporan/get_neraca_saldo/')?>"+bulan+"/"+tahun,
			success:function(data){
				$("tbody").append(data);
				$("#data-row").fadeIn();
				$("#btnCetak").show();
			}
		});
	})
	    function printDiv() {

      var divToPrint=document.getElementById('data-row');

      var newWin=window.open('','Print-Window');

      newWin.document.open();
      newWin.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/style.default.css" id="theme-stylesheet"></head>');

      newWin.document.write('<body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();});

    }
</script>