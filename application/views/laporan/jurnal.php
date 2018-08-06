<style type="text/css">
    .judul{
        text-align: center;
    }
</style>
<div class="row">
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Pilih Tanggal
        </div>
        <div class="card-body">
            <form class="form-inline" method="POST" action="<?php echo site_url('Laporan/jurnal')?>">
                <div class="form-group">
                    <label for="tgl_awal">Tanggal Awal</label>
                    <input name="tgl_awal" id="tgl_awal" type="date" class="mx-sm-3 form-control form-control">
                </div>
                <div class="form-group">
                    <label for="tgl_akhir">Tanggal Akhir</label>
                    <input name="tgl_akhir" id="tgl_akhir" type="date" class="mx-sm-3 form-control form-control">
                </div>
                <div class="form-group">
                    <input id="btnsubmit" name="btnsubmit" type="submit" value="Tampilkan" class="mx-sm-3 btn btn-primary">
                </div>
                <button class="btn btn-success" onclick="printDiv()"><i class="fa fa-print"></i> Cetak PDF</button>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row" id="row_cetak">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="judul">Jurnal Umum</h4>
                <h4 class="judul">KPRI Rukun Makmur</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Ref</th>
                            <th colspan="2"><center>Debet</center></th>
                            <th colspan="2"><center>Kredit</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $spasi = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                            foreach($jurnal as $data){?>
                                <tr>
                                    <td><?php echo $data->tgl_trans?></td>
                                    <?php
                                        if($data->posisi_dr_cr == 'd'){?>
                                            <td><?php echo $data->nama_akun?></td>
                                            <td><?php echo $data->no_akun?></td>
                                            <?php echo format_rp_table($data->nominal)?>
                                            <td></td>   
                                            <td></td> 
                                    <?php
                                        }else{?>
                                            <td><?php echo $spasi.$data->nama_akun?></td>
                                            <td><?php echo $data->no_akun?></td>
                                            <td></td>
                                            <td></td>
                                            <?php echo format_rp_table($data->nominal)?>
                                    <?php
                                        }
                                    ?>
                                    
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><?php echo $this->pagination->create_links(); ?></td>
                        </tr>
                        
                    </tfoot>
                </table> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv() {

      var divToPrint=document.getElementById('row_cetak');

      var newWin=window.open('','Print-Window');

      newWin.document.open();
      newWin.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/style.default.css" id="theme-stylesheet"></head>');

      newWin.document.write('<body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();},5);

    }
</script>