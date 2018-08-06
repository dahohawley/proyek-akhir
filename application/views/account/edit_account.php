<?php
    if($this->session->userdata('hak_akses') == '1'){
      $hak_akses = 'ketua';
    }elseif($this->session->userdata('hak_akses') == '2'){
      $hak_akses = 'bendahara';
    }else{
      $hak_akses = 'kasir';
    }  
?>   
<button class="btn btn-primary" data-toggle="collapse" data-target="#system-setting">System Setting</button> 
<br><br>
<div class="row bg-white has-shadow collapse" id="system-setting">
    <div class="col-md-12">
        <br>
        <h3>System Setting</h3>
        <hr>
    </div>
    <div class="col-md-12">
        <button class="btn btn-primary" id="deleteData">Hapus Data</button>
        <button class="btn btn-primary" id="deleteDataPenjualan">Hapus Pembelian dan Penjualan</button>
        <br>
        <br>
    </div>
</div>
<br>
<div class="row bg-white has-shadow">
    <div class="col-md-12">
        <br>
        <h3>Informasi Akun</h3>
        <hr>
    </div>
    <div class="col-md-12">
        <form class="form-horizontal" action="#" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $account->username?>" disabled="">
            </div>
            <div class="form-group">
                <label>Hak Akses</label>
                <input type="text" name="hak_akses" class="form-control" value="<?php echo $account->hak_akses?>" disabled>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="Password" name="password" class="form-control" value="<?php echo $account->password?>" disabled>
                <small><a href="#">Ubah Password</a></small>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <br>
        <h3>Informasi Pengguna</h3>
        <hr>
    </div>
    <div class="col-md-12">
        <form enctype="multipart/form-data" id="submit">
           <div class="form-group">
                <label>Upload Photo:</label>
                <input name="file" type="file"  id="image_file" required class="form-control" accept="image/*">
           </div>
           <div class="form-group">
             <button type="submit" class="btn btn-primary" id="sub">Upload</button>
           </div>
        </form>
    </div>
    <div class="col-md-12">
        <form class="form-horizontal" action="" id="form-data" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $personal->nama?>" readonly>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="ubah_nama">Ubah</button>
                <button class="btn btn-danger" type="button" id="batal_nama" style="display: none;">Batal</button>
              </div>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"><?php echo $personal->alamat?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan">
            </div>
        </form>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<script type="text/javascript">
    $(document).ready(function(){
        var nama_form = "";
        $("#ubah_nama").click(function(){
            $("input[name='nama']").removeAttr("readonly");
            $("input[name='nama']").focus();
            $("#ubah_nama").hide();
            $("#batal_nama").attr("style",'display:block');
            nama_form = $("input[name='nama']").val();
        });
        $("#batal_nama").click(function(){
            $("input[name='nama']").attr("readonly",'readonly');
            $("#ubah_nama").show();
            $("#batal_nama").attr("style",'display:none');
            $("input[name='nama']").val(nama_form);
            $("#nama-error").attr('style','display:none');
        });
    });
    $("#deleteData").click(function(e){
        e.preventDefault();
        if (confirm("Anda yakin ingin menghapus semua data transaksi yang pernah terjadi?")) {

            var person = prompt("Ketik 'Hapus' tanpa tanda petik untuk melanjutkan");
            if (person == null || person == "") {
                txt = "Data tidak dihapus";
            } else {
                $.ajax({
                    url:"<?php echo site_url('account/delete_all_trans')?>",
                    success:function(data){
                        alert("Data dihapus.");
                    }
                });
            }

        } else {
            alert("Data tidak dihapus.");
        }
    });
     $("#deleteDataPenjualan").click(function(e){
        e.preventDefault();
        if (confirm("Anda yakin ingin menghapus semua data transaksi penjualan dan pembelian yang pernah terjadi?")) {

            var person = prompt("Ketik 'Hapus' tanpa tanda petik untuk melanjutkan");
            if (person == null || person == "") {
                txt = "Data tidak dihapus";
            } else {
                $.ajax({
                    url:"<?php echo site_url('account/delete_penjualan_pembelian')?>",
                    success:function(data){
                        alert("Data dihapus.");
                    }
                });
            }

        } else {
            alert("Data tidak dihapus.");
        }
    })
    $("#form").validate({
        rules: {
            nama: "required"
        },
        messages:{
            nama:"Nama tidak boleh kosong."
        },
        submitHandler: function(form){
           form.submit();
        }
    });
    $("#form-data").submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo site_url('account/update_data')?>",
            type:"POST",
            data:$("#form-data").serialize(),
            success:function(){
                nama_form = $("input[name='nama']").val();
                $("input[name='nama']").attr("readonly",'readonly');
                $("#ubah_nama").show();
                $("#batal_nama").attr("style",'display:none');
                $("input[name='nama']").val(nama_form);
                $("#nama-error").attr('style','display:none');
                $.notify({
                     // options
                     tittle: 'Berhasil dirubah',
                     icon: 'fa fa-check',
                     message: 'Data berhasil diubah<br />'
                 }, {
                     // settings
                     placement: {
                         align: 'center'
                     },
                     delay: "20",
                     type: 'success'
                 }); 
            }
        });
    });
    $('#submit').submit(function(e){
        e.preventDefault(); 
         $.ajax({
             url:'<?php echo site_url('account/do_upload')?>',
             type:"post",
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:false,
              success: function(data){
                 $.notify({
                     // options
                     tittle: 'Berhasil dirubah',
                     icon: 'fa fa-check',
                     message: 'Data berhasil diubah<br />'
                 }, {
                     // settings
                     placement: {
                         align: 'center'
                     },
                     delay: "20",
                     type: 'success'
                 });
           }
        });
    });  
</script>