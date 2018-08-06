<div class="row bg-white has-shadow" id="content">
                <div class="col-md-12">
                    <form id="form" action="<?php echo base_url('index.php/Angsuran/selesai')?>" method="POST">
                        <div class="form-group">
                            <br>
                            <label>Nama Anggota</label>
                            <div class="form-group">
                                <input type="hidden" name="id_angsuran" value="<?php echo $id_angsuran?>">
                                 <input type="hidden" name="no_anggota" id="no_anggota" value="<?php echo $anggota->no_anggota?>">
                                <input type="text" id="no_anggota" class="form-control" value="<?php echo $anggota->nama ?>" readonly>
                            </div> 
                            <label>Kode Pinjaman</label>
                            <div class="form-group">
                                <input type="text" name="id_pinjam" id="id_pinjam" value="<?php echo $kode_pinjaman->id_pinjam ?>" class="form-control" readonly>
                            </div>
                            <label>Jumlah Angsuran</label>
                            <div class="form-group">
                                <input name="jml_angsur" class="form-control" id="jml_angsur"  value="<?php echo format_rp($kode_pinjaman->tarif_angsur) ?>" readonly="">
                            </div>
                            <label>Periode</label>
                            <div class="form-group">
                                <input type="text" name="periode" id="periode" class="form-control" readonly="">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>  
</div>
<!-- Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- ajax -->
<script type="text/javascript">
    $(document).ready(function(){
        var no_anggota = $("#no_anggota").val();
        var id_pinjam = $("#id_pinjam").val();
        $.ajax({
            url:"<?php echo base_url('index.php/Angsuran/get_periode/')?>"+id_pinjam+"/"+no_anggota+"/",
            type:"GET",
            success:function(data){
                $("#periode").empty();
                $("#periode").val(data);
            }
        })
    })
</script>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>
<script type="text/javascript">
</script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    $("#form" ).validate({
      rules: {
        no_anggota: "required",
        id_jenis: {
            required : true
        },
        tahun : {
            required : true,
            digits : true,
            minlength : 4,
            maxlength : 4,
            min : 2000,
            max : 9999
        },
        periode : "required"
      },
      messages:{
        no_anggota : "Nama Anggota tidak boleh kosong",
        id_jenis: {
            required: "Simpanan tidak boleh kosong."
        },
        tahun : {
            required : "Tahun tidak boleh kosong",
            digits : "Tahun hanya berisi angka bulat positif",
            minlength : "Tahun tidak boleh kurang dari 4 karakter",
            maxlength : "Tahun tidak boleh lebih dari 4 karakter",
            min : "Tahun tidak boleh kurang dari tahun 2000",
            max : "Tahun tidak boleh lebih dari tahun 9999"
        },
        periode : "Periode tidak boleh kosong"
      }
    });
})
</script>
