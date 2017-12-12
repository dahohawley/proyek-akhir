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
            <form class="form-inline">
                <div class="form-group">
                    <label for="tgl_awal">Tanggal Awal</label>
                    <input id="tgl_awal" type="date" class="mx-sm-3 form-control form-control">
                </div>
                <div class="form-group">
                    <label for="tgl_akhir">Tanggal Akhir</label>
                    <input id="tgl_akhir" type="date" class="mx-sm-3 form-control form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="mx-sm-3 btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row">
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
                            <th>Tanggal Transaksi</th>
                            <th>ID Transaksi</th>
                            <th>Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $spasi = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                            foreach($jurnal as $data){?>
                                <tr>
                                    <td><?php echo $data->tgl_trans?></td>
                                    <td><?php echo $data->id_trans?></td>
                                    <td><?php echo $data->no_akun?></td>
                                    <?php
                                        if($data->posisi_dr_cr == 'd'){?>
                                            <td><?php echo $data->nama_akun?></td>
                                            <td><?php echo format_rp($data->nominal)?></td>
                                            <td></td>    
                                    <?php
                                        }else{?>
                                            <td><?php echo $spasi.$data->nama_akun?></td>
                                            <td></td>
                                            <td><?php echo format_rp($data->nominal)?></td>
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
                            <td colspan="6"><?php echo $this->pagination->create_links(); ?></td>
                        </tr>
                        
                    </tfoot>
                </table> 
            </div>
        </div>
    </div>
</div>