<div class="row" id="data-row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Rencana Pembagian SHU Tahun <?php echo date('Y') ?>
      </div>
      <div class="card-body">
        <table class="table table-hover table-bordered">
          <tr>
            <th>RENCANA PEMBAGIAN SHU UNIT SIMPAN PINJAM</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <?php
          foreach ($pemb_usp as $data) {?>
            <tr>
              <td><?php echo $data->nama_obyek ?></td>
              <td><?php echo $data->prosentase ?>%</td>
              <td>X</td>
              <td><?php echo format_rp($shu_usp) ?></td>
              <td>=</td>
              <td><?php echo format_rp($shu_usp*$data->prosentase/100) ?></td>
            </tr>
          <?php
          }
          ?>
          <tr>
            <th>JUMLAH</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><?php echo format_rp($shu_usp) ?></th>
          </tr>
        </table>
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/filter_shu/')?>" method="POST">
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

      var divToPrint=document.getElementById('data-row');

      var newWin=window.open('','Print-Window');

      newWin.document.open();
      newWin.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/style.default.css" id="theme-stylesheet"></head>');

      newWin.document.write('<body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();});

    }
</script>
