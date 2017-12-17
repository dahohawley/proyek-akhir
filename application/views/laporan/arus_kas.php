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
									<option value="<?php echo $i?>"><?php echo $i?></option>
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
				<h5 class="judul">Periode <?php echo date('Y')?></h5>
			</div>
			<div class="card-body">
				<table class="table table-hover table table-bordered">
				  <!-- operasional row-->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Operasional</th>
				  </tr>
				  <tr>
				    <td>Penjualan</td>
				    <td id="penjualan-data"></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Return Pembelian</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembelian Persediaan Barang</td>
				    <td id="pbd-data"></td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Total Biaya &amp; Beban</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Pembayaran Pajak Usaha</td>
				    <td>-</td>
				    <td></td>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktivitas Operasional</td>
				    <td></td>
				    <td id="ak-op">-</td>
				  </tr>
				  <!--investasi row -->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Investasi</th>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktivitas Investasi</td>
				    <td></td>
				    <td>-</td>
				  </tr>
				  <!--pendanaan row -->
				  <tr style="background-color:#6C7A89; color: white;">
				    <th colspan="3">Aktivitas Pendanaan</th>
				  </tr>
				  <tr>
				    <td>Arus Kas Untuk Aktivitas Investasi</td>
				    <td></td>
				    <td>-</td>
				  </tr>
				  <tr style="background-color:#95A5A6; color: white;">
				  	<td>Kas Pada Akhir Periode</td>
				  	<td></td>
				  	<td id="kat"></td>
				  </tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#data-row").hide();
		$("#btnCari").click(function(){
			var bulan = $("#bulan").val();
			var tahun = $("#tahun").val();
			$.ajax({
				url:"<?php echo site_url('laporan/get_arus_kas/')?>"+tahun+'/'+bulan,
				success:function(data){
					$("#data-row").fadeOut();
					$("#penjualan-data").text(data.penjualan);
					$("#pbd-data").text(data.pbd);
					$("#ak-op").text(data.ak_op);
					$("#kat").text(data.ak_op);
					$("#data-row").fadeIn();
				}
			});
		})
	})
</script>