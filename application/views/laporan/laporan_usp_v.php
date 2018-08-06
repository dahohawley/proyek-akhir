<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Periode</div>
            <div class="card-body">
                <form method="POST" action="#" id="formPeriode">
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
        Penerimaan Jasa Unit Simpan Pinjam
    </div>
    <div class="card-body">
        <div id="table-print">
        <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">No Anggota</th>
            <th rowspan="2">Nama Anggota</th>
            <th rowspan="2">Sisa Pinjaman</th>
            <th colspan="4"><center>Jasa Anggota</center></th>
          </tr>
          <tr>
            <th>Jasa Peminjam</th>
            <th>Jasa SP&amp;SW</th>
            <th>Jasa SMN,SHR,S.Pend</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody id="data-body">
            
        </tbody>
        <tfoot id="data-footer">
            
        </tfoot>
        </table>
        <div class="buttonDiv">
            
        </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    var grand_total;
    $(document).ready(function(){
        $("#row-data").hide();
        $("#btnCetak").hide();
        $("#btnAJP").hide();
        $("#btnCari").click(function(){
            $("#data-body").empty();
            $("#data-footer").empty();
            $.ajax({
                type:"POST",
                url: "<?php echo base_url('index.php/laporan/get_penerimaan_usp')?>",
                data: $("#formPeriode").serialize(),
                success:function(data){
                    obj = data.split('|');
                    $("#row-data").fadeIn("slow");
                    $("#btnCetak").show();
                    $("#data-body").append(obj[0]);
                    $("#data-footer").append(obj[1]);
                    grand_total = obj[2]*1;
                    var button_stat = obj[3];
                    if(button_stat == 'true'){
                        $(".buttonDiv").empty();
                        $(".buttonDiv").append("<button class='btn btn-primary' onclick='generate_ajp()'>Generate AJP</button>");
                    }else{
                        $(".buttonDiv").empty();
                        $(".buttonDiv").append("<button class='btn btn-primary' disabled>Telah digenerate</button>");
                    }
                }
            });
        });
    });
    function generate_ajp(){
        var tahun = $("#tahun").val();
        $.ajax({
            url:"<?php echo site_url('laporan/generate_ajp_penerimaan_sp/')?>"+tahun,
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
      var style = '<link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css">'
      var newWin=window.open('','Print-Window');
      newWin.document.open();
      newWin.document.write('<html><head>'+style+'</head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
      newWin.document.close();
      setTimeout(function(){newWin.close();},10);

    }
</script>