<style type="text/css">
  .judul{
    text-align: center;
  }
</style>
<div class="row" id="body_phu">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="judul">KPRI Rukun Makmur</h4>
        <h4 class="judul">Perhitungan Hasil Usaha</h4>
        <h4 class="judul">Unit Unit Simpan Pinjam</h4>
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
            <td>Pendapatan Jasa</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Jasa atas pinjaman yang diberikan</td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><?php echo format_rp($jasa) ?></td>
          </tr>
          <tr>
            <td></td>
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
          <?php 
          foreach ($b_op as $data) {?>
            <tr>
              <td><?php echo $data->nama_akun?></td>
              <td style="text-align:right;"><?php echo format_rp($data->nominal) ?></td>
              <td></td>
              <td></td>
            </tr>
          <?php
          }
           ?>
           <tr>
            <td>JUMLAH BEBAN OPERASIONAL</td>
            <td></td>
            <td style="text-align:right;"><?php echo format_rp($jml_operasional) ?></td>
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
          <?php 
          foreach ($b_op as $data) {?>
            <tr>
              <td><?php echo $data->nama_akun?></td>
              <td style="text-align:right;"><?php echo format_rp($data->nominal) ?></td>
              <td></td>
              <td></td>
            </tr>
          <?php
          }
           ?>
          <tr>
            <td>JUMLAH BEBAN NON-OPERASIONAL</td>
            <td></td>
            <td style="text-align:right;"><?php echo format_rp($jml_non) ?></td>
            <td></td>
          </tr>
           <tr>
            <td>TOTAL BEBAN</td>
            <td></td>
            <td></td>
            <td style="text-align:right;">(<?php echo format_rp($jml_non+$jml_operasional) ?>)</td>
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
            <td style="text-align:right;"><?php echo format_rp($jasa-$jml_operasional-$jml_non) ?></td>
          </tr>
          <tr>
            <td>Pajak 1%</td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><?php echo format_rp(($jasa-$jml_operasional-$jml_non)*1/100) ?></td>
          </tr>
           <tr>
            <td>TOTAL SHU</td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><?php echo format_rp(($jasa-$jml_operasional-$jml_non)-(($jasa-$jml_operasional-$jml_non)*1/100)) ?></td>
          </tr>
        </table>
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/filter_phu/')?>" method="POST">
  <div class="form-group">
          <input type="submit" value="Kembali" class="mx-sm-3 btn btn-primary">
          <button id="btnCetak" class="btn btn-success" onclick="printDiv()"><i class="fa fa-print"></i> Cetak PDF</button>
  </div>
</form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function printDiv() {

      var divToPrint=document.getElementById('body_phu');

      var newWin=window.open('','Print-Window');

      newWin.document.open();
      newWin.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/style.default.css" id="theme-stylesheet"></head>');

      newWin.document.write('<body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();});

    }
</script>