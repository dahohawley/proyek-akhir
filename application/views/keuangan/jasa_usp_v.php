<style type="text/css">
    .judul{
        text-align: center;
    }.tg  {border-collapse:collapse;border-spacing:0;}
.tg th{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-e3zv{font-weight:bold}
.tg .tg-hgcj{font-weight:bold;text-align:center}
.tg .tg-34fq{font-weight:bold;text-align:right}
.tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-9hbo{font-weight:bold;vertical-align:top}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Periode
            </div>
            <div class="card-body">
                <form class="form-inline" id="form-periode" action="<?php echo site_url('keuangan/get_penerimaan_usp')?>">
                    <div class="form-group"> 
                        <select class="mx-sm-3 form-control" name="tahun" id="tahun">
                            <option selected="" disabled="" >Tahun</option>
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
                    <input type="submit" value="Cari" class="mx-sm-3 btn btn-primary" id="btnCari">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="row-table">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="judul">Daftar Penerimaan Jasa USP</h4>
                <h4 class="judul">KPRI Rukun Makmur</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="tg-e3zv" rowspan="2">No</th>
                        <th class="tg-hgcj" rowspan="2">No Anggota</th>
                        <th class="tg-34fq" rowspan="2">Nama Anggota</th>
                        <th class="tg-e3zv"></th>
                        <th class="tg-e3zv"></th>
                        <th class="tg-e3zv"></th>
                        <th class="tg-amwm" colspan="3">Jasa Anggota</th>
                      </tr>
                      <tr>
                        <th class="tg-e3zv">Sisa Pinjaman</th>
                        <th class="tg-e3zv">Jasa</th>
                        <th class="tg-e3zv">Jasa Peminjam</th>
                        <th class="tg-9hbo">Jasa SP &amp; SW</th>
                        <th class="tg-9hbo">Jasa SMN,SHR,S.Pend</th>
                        <th class="tg-9hbo">Jumlah</th>
                      </tr>
                    </thead>
                    <tbody id="body-table">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#row-table").hide();
        $("#btnCari").click(function(){
            $.ajax({
                type:"POST",
                url:$("#form-periode").attr('action'),
                data: $("#form-periode").serialize(),
                success:function(data){
                    $("#row-table").fadeIn();
                    $("#body-table").empty();
                    $("#body-table").append(data);
                },
            });
        });
    });
</script>