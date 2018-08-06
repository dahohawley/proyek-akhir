<div class="row bg-white has-shadow" id="content">
				<div class="col-md-12">
					<form id="form" action="<?php echo base_url('index.php/Pinjaman/selesai_cairkan')?>" method="POST">
						<div class="form-group">
                            <br>
							<div class="form-group">
								<input type="hidden" name="id_pinjam" value="<?php echo $pinjaman->id_pinjam?>">
                                <label>Nomor Anggota</label>
								<input type="text" name="no_anggota" class="form-control" id="no_anggota" value="<?php echo $pinjaman->no_anggota ?>" readonly>
							</div> 
                            <div class="form-group">
                                <label>Nama Anggota</label>
                                <input class="form-control" id="no_anggota" value="<?php echo $pinjaman->nama?>" readonly>
                            </div> 
                            <div class="form-group">
                                <label>Jumlah Pinjam</label>
                                <input type="text" name="jml_pinjam" id="jml_pinjam" class="form-control" value="<?php echo format_rp($pinjaman->jml_pinjam) ?>" readonly>
                            </div> 
                            <div class="form-group">
                                <label>Banyak Angsuran</label>
                                <input type="text" name="banyak" id="banyak" class="form-control" value="<?php echo $pinjaman->banyak_angsuran?>" onchange="get_jatuh_tempo()" readonly>
                            </div> 
                             <div class="form-group">
                                <label>Angsuran Perbulan+Bunga 1.2%</label>
                                <input type="text" name="angsur" id="angsur" class="form-control" value="<?php echo format_rp($pinjaman->tarif_angsur) ?>" readonly>
                            </div> 
                             <div class="form-group">
                                <label>Jatuh Tempo</label>
                                <input type="text" name="jatuh_tempo" id="jatuh_tempo" class="form-control" value="<?php echo $jatuh_tempo->jatuh_tempo ?>" readonly>
                            </div> 
							<input type="submit" class="btn btn-primary" value="Cairkan">
						</div>
					</form>
				</div>	
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- ajax -->
<script type="text/javascript">
    function get_jatuh_tempo() {
         var banyak = $("#banyak").val();
         $.ajax({
             url: "<?php echo base_url('index.php/Pinjaman/get_jatuh_tempo/')?>" + banyak,
             type: "GET",
             success: function(data) {
                 $("#jatuh_tempo").val(data);
             }
         })
     }
</script>
<!-- End Bootstrap modal -->
<script type="text/javascript">
</script>
