<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				Periode
			</div>
			<div class="card-body">
				<form class="form-inline">
					<div class="form-group">
						<select name="bulan" class="mx-sm-3 form-control" id="bulan">
							<option selected="" disabled="">Bulan</option>
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
				<h4 class="judul">Laporan Arus Kas</h4>
				<h4 class="judul">KPRI Rukun Makmur</h4>
				<h5 class="judul">Periode <i id="bulan_text"></i> <i id="tahun_text"></i></h5>
			</div>
			<div class="card-body">
				<table class="table table-hover table table-bordered">
				  <!-- operasional row-->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Operasional</th>
				  </tr>
				  <tr>
				    <td>Saldo Awal Kas</td>
				    <td></td>
				    <td style="text-align: right;" id="awal_kas"></td>
				  </tr>
				  <tr>
				    <td>Penjualan</td>
				    <td style="text-align: right;" id="penjualan-data"></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Return Pembelian</td>
				    <td style="text-align: right;">-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembelian Persediaan Barang</td>
				    <td style="text-align: right;" id="pbd-data"></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Total Biaya &amp; Beban</td>
				    <td style="text-align: right;" id="total_beban"></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembayaran Pajak Usaha</td>
				    <td style="text-align: right;" >-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktivitas Operasional</td>
				    <td></td>
				    <td  style="text-align: right;" id="ak-op">-</td>
				  </tr>
				  <!--investasi row -->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Investasi</th>
				  </tr>
				  <tr>
				    <th colspan="3">Arus kas Masuk</th>
				  </tr>
				  <tr>
				    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Simpanan</td>
				    <td style="text-align: right;" id="total_simpanan"></td>
				  </tr>
				  <tr>
				    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Angsuran</td>
				    <td id="angsuran" style="text-align: right;" >-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <th colspan="3">Arus kas Keluar</th>
				  </tr>
				  <tr>
				    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Pinjaman</td>
				    <td style="text-align: right;" id="pinjaman" >-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Penarikan</td>
				    <td style="text-align: right;" id="penarikan" >-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <th colspan="2">Total Arus Kas Investasi</th>
				    <th id="ak_it" style="text-align: right;"></th>
				  </tr>
				  <!--pendanaan row -->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Pendanaan</th>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktivitas Pendanaan</td>
				    <td></td>
				    <td style="text-align: right;" >-</td>
				  </tr>
				  <tr style="background-color:#95A5A6; color: white;">
				  	<td>Kas Pada Akhir Periode</td>
				  	<td></td>
				  	<td style="text-align: right;"  id="kat"></td>
				  </tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		// $("#data-row").hide();
		$("#btnCetak").hide();
		$("#btnCari").click(function(){
			var bulan = $("#bulan").val();
			var tahun = $("#tahun").val();
			$.ajax({
				url:"<?php echo site_url('laporan/get_arus_kas/')?>"+tahun+'/'+bulan,
				success:function(data){
					$("#btnCetak").show();
					$("#data-row").fadeOut();
					$("#penjualan-data").text(data.penjualan);
					$("#pbd-data").text(data.pbd);
					$("#ak-op").text(data.ak_op);
					$("#kat").text(data.kat);
					$("#total_beban").text(data.beban);
					$("#bulan_text").empty();
					$("#tahun_text").empty();
					$("#total_simpanan").empty();
					$("#total_simpanan").text(data.simpanan);
					$("#penarikan").empty();
					$("#penarikan").text(data.penarikan);
					$("#awal_kas").empty();
					$("#awal_kas").text(data.saldo_awal_kas);
					$("#ak_it").empty();
					$("#ak_it").text(data.ak_it);
					$("#pinjaman").empty();
					$("#pinjaman").text(data.pinjaman);
					$("#angsuran").empty();
					$("#angsuran").text(data.angsuran);
					$("#bulan_text").append(data.bulan);
					$("#tahun_text").append(data.tahun);
					$("#data-row").fadeIn();
				}
			});
		})
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