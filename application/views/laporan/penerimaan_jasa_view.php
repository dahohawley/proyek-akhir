<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				Penerimaan Jasa
			</div>
			<div class="card-body">
				<button class="btn btn-primary" id="simpan_pinjam">Unit Simpan Pinjam</button>
				<button class="btn btn-primary" id="toko">Unit Toko</button>
			</div>
		</div>
	</div>
</div>
<div id="row1">
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#simpan_pinjam").click(function(){
			$.ajax({
				url:"<?php echo site_url('laporan/penerimaan_usp')?>",
				success:function(data){
					$("#row1").empty();
					$("#row1").fadeOut("slow");
					$("#row1").append(data);
					$("#row1").fadeIn("slow");

				}
			})
		})
		$("#toko").click(function(){
			$.ajax({
				url:"<?php echo site_url('laporan/penerimaan_toko')?>",
				success:function(data){
					$("#row1").empty();
					$("#row1").fadeOut("slow");
					$("#row1").append(data);
					$("#row1").fadeIn("slow");

				}
			})
		})
	})
</script>