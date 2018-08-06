<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				Periode
			</div>
			<div class="card-body">
				<form method="POST" id="formPeriode">
					 <div class="form-group">
                        <label>Periode</label>
                        <select class="form-control" name="tahun" id="tahun">
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
	                        <button class="btn btn-primary" id="btnCari">Tampilkan</button>
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
				Penerimaan Jasa Toko
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th><center>No</center></th>
							<th ><center>Nomor Anggota</center></th>
							<th ><center>Nama</center></th>
							<th ><center>Sisa Pinjaman</center></th>
							<th ><center>Jasa Anggta</center></th>
							<th ><center>Pemerataan</center></th>
							<th><center>SHU Diterima</center></th>
						</tr>
					</thead>
					<tbody id="data">
						
					</tbody>
				</table>
				<div class="buttonDiv">
					
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#btnCetak").hide();
		$("#data-row").hide();
		$("#btnCari").click(function(){
			$("#data-row").fadeOut();
			$.ajax({
				url:"<?php echo site_url('laporan/get_penerimaan_toko')?>",
				type:"POST",
				data:$("#formPeriode").serialize(),
				success:function(data){
					obj = data.split('|');
					$("#data-row").fadeIn();
					$("#data").empty();
					$("#data").append(obj[0]);
					$("#btnCetak").show();
					var button_stat = obj[1];
                    if(button_stat == 'true'){
                        $(".buttonDiv").empty();
                        $(".buttonDiv").append("<button class='btn btn-primary' onclick='generate()'>Generate AJP</button>")
                    }else{
                        $(".buttonDiv").empty();
                        $(".buttonDiv").append("<button class='btn btn-primary' disabled>Telah digenerate</button>");
                    }
				}
			});
		});	
	});
	function generate(){
		var tahun = $("#tahun").val();
		$.ajax({
		    url:"<?php echo site_url('laporan/generate_ajp_penerimaan_jt/')?>"+tahun,
		    success:function(data){
		        if(data == 'true'){
		            alert('Berhasil membuat jurnal..');
		            $("#simpan_pinjam").trigger('click');
		        }else{
		            alert('Gagal membuat jurnal');
		        }
		    }
		});
	}
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