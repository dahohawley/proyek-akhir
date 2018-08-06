<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Rencana Pembagian SHU Tahun <?php echo date('Y') ?>
      </div>
      <div class="card-body">
        <table class="table table-hover table-bordered">
          <tr>
            <th>RENCANA PEMBAGIAN SHU UNIT SIMPAN PINJAM DAN UNIT TOKO</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
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
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th>RENCANA PEMBAGIAN SHU UNIT TOKO</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <?php
          foreach ($pemb_toko as $data) {?>
            <tr>
              <td><?php echo $data->nama_obyek ?></td>
              <td><?php echo $data->prosentase ?>%</td>
              <td>X</td>
              <td><?php echo format_rp($shu_toko) ?></td>
              <td>=</td>
              <td><?php echo format_rp($shu_toko*$data->prosentase/100) ?></td>
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
            <th><?php echo format_rp($shu_toko) ?></th>
          </tr>
        </table>
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/filter_shu/')?>" method="POST">
          <div class="form-group">
                  <input type="submit" value="Kembali" class="mx-sm-3 btn btn-primary">
          </div>
          <div class="form-group">
              <?php
              if(date('d') > 27 && date('m') == 12){?>
               <a href="<?php echo site_url('laporan/generate_ajp_shu/')?>" class="btn btn-info"> Generate AJP</a>
              <?php
                }
              ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
