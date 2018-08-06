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
            <td><?php echo format_rp($jasa) ?></td>
          </tr>
          <tr>
            <td>Penjualan Barang Dagangan</td>
            <td></td>
            <td><?php echo format_rp($penjualan) ?></td>
            <td></td>
          </tr>
          <tr>
            <td>Pembelian Bersih</td>
            <td></td>
            <td><?php echo format_rp($pemb) ?></td>
            <td></td>
          </tr>
          <tr>
            <td>Pendapatan Penjualan</td>
            <td></td>
            <td></td>
            <td><?php echo format_rp($penjualan-$pemb) ?></td>
          </tr>
          <tr>
            <td>Pendapatan Kotor</td>
            <td></td>
            <td></td>
            <td><?php echo format_rp($penjualan+$penjualan-$pemb) ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>BEBAN OPERASIONAL TOKO</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <?php 
          foreach ($b_toko as $data) {?>
            <tr>
              <td><?php echo $data->nama_akun?></td>
              <td><?php echo format_rp($data->nominal) ?></td>
              <td></td>
              <td></td>
            </tr>
          <?php
          }
           ?>
          <tr>
            <td>JUMLAH BEBAN OPERASIONAL TOKO</td>
            <td></td>
            <td><?php echo format_rp($jml_toko) ?></td>
            <td></td>
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
              <td><?php echo format_rp($data->nominal) ?></td>
              <td></td>
              <td></td>
            </tr>
          <?php
          }
           ?>
           <tr>
            <td>JUMLAH BEBAN OPERASIONAL</td>
            <td></td>
            <td><?php echo format_rp($jml_operasional) ?></td>
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
              <td><?php echo format_rp($data->nominal) ?></td>
              <td></td>
              <td></td>
            </tr>
          <?php
          }
           ?>
          <tr>
            <td>JUMLAH BEBAN NON-OPERASIONAL</td>
            <td></td>
            <td><?php echo format_rp($jml_non) ?></td>
            <td></td>
          </tr>
           <tr>
            <td>TOTAL BEBAN</td>
            <td></td>
            <td></td>
            <td>(<?php echo format_rp($total_beban) ?>)</td>
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
            <td><?php echo format_rp($pend_bbn) ?></td>
          </tr>
          <tr>
            <td>Pajak 1%</td>
            <td></td>
            <td></td>
            <td><?php echo format_rp($pajak) ?></td>
          </tr>
           <tr>
            <td>TOTAL SHU TAHUN <?php echo $tahun ?></td>
            <td></td>
            <td></td>
            <td><?php echo format_rp($shu) ?></td>
          </tr>
        </table>
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/filter_phu/')?>" method="POST">
  <div class="form-group">
          <input type="submit" value="Kembali" class="mx-sm-3 btn btn-primary">
          <button id="btnCetak" class="btn btn-success" onclick="printDiv()"><i class="fa fa-print"></i> Cetak PDF</button>
  </div>
  <div class="form-group">
          <?php
            if(date('d') > 27){?>
             <a href="<?php echo site_url('laporan/generate_ajp_pajak/'.$pajak)?>" class="btn btn-info"> Generate AJP</a>
          <?php
            }
          ?>
 </div>
</form>
      </div>
    </div>
  </div>
</div>
