<style type="text/css">
  .judul{
    text-align: center;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-danger">
      <i class="fa fa-danger"></i>Angka akan muncul pada akhir periode
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="judul">KPRI Rukun Makmur</h4>
        <h4 class="judul">Perhitungan Hasil Usaha</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover table-bordered">
          <tr>
            <th>PENDAPATAN DAN BIAYA OPERASIONAL</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <td>PENDAPATAN OPERASIONAL</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>1. Pendapatan Jasa</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Jasa atas pinjaman yang diberikan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>BEBAN OPERASIONAL</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Hr Karyawan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Transport Pembantu Pengurus</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Transport Pengurus</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Transport Pengawas</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Transport Penasehat</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban ATK</td>
            <td></td>
            <td><</td>
            <td></td>
          </tr>
           <tr>
            <td>Beban Promosi</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>JUMLAH BEBAN OPERASIONAL</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>BEBAN NON-OPERASIONAL</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Rapat Pengurus dan BP</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Kebersihan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Transport</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Denda Pajak</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban RAT</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Penyusutan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Beban Pembinaan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>JUMLAH BEBAN NON-OPERASIONAL</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
           <tr>
            <td>TOTAL BEBAN</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
           <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
           <tr>
            <td>PENDAPATAN KURANGI BEBAN</td>
            <td></td>
            <td></td>
            <td><</td>
          </tr>
          <tr>
            <td>Pajak 1%</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
           <tr>
            <td>TOTAL SHU TAHUN <?php echo date('Y') ?></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/filter_phu/')?>" method="POST">
  <div class="form-group">
          <input type="submit" value="Kembali" class="mx-sm-3 btn btn-primary">
  </div>
</form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

  });
  function get_phu(){
    $("#body_phu").hide();
    $("tbody").empty();
    var bulan = $("#bulan").val();
    var unit = $("#unit").val();
    var tahun = $("#tahun").val(); 
    $.ajax({
      url:"<?php echo site_url('Laporan/get_phu/')?>"+unit+"/"+bulan+"/"+tahun,
      success:function(data){
        $("#body_phu").fadeIn();
        $("tbody").append(data);
      }
    });
  }
</script>