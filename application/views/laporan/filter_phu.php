<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Filter
      </div>
      <div class="card-body">
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/phu/')?>" method="POST">
          <div class="form-group">
            <select name="bulan_awal" class="mx-sm-3 form-control" id="bulan">
              <option selected="" disabled="">Dari</option>
              <?php
                for($i=1;$i<=12;$i++){?>
                  <option value="<?php echo $i?>"><?php echo get_monthname($i)?></option>
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <select name="bulan_akhir" class="mx-sm-3 form-control" id="bulan">
              <option selected="" disabled="">Sampai</option>
              <?php
                for($i=1;$i<=12;$i++){?>
                  <option value="<?php echo $i?>"><?php echo get_monthname($i)?></option>
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group"> 
            <select class="mx-sm-3 form-control" id="tahun" name="tahun">
              <option selected="" disabled="" >Tahun</option>
              <?php
                foreach($tahun as $data){?>
                  <option value="<?php echo $data->tahun?>"><?php echo $data->tahun?></option>
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group"> 
            <select class="mx-sm-3 form-control" id="unit" name="unit">
              <option selected="" disabled="" >Pilih Unit</option>
              <option value="1">Simpan Pinjam</option>
              <option value="2">Toko</option>
              <option value="3">Gabungan</option>
            </select>
          </div>
          <div class="form-group">
          <input type="submit" value="Cari" class="mx-sm-3 btn btn-primary">
        </div>
        </form>
        
      </div>
    </div>
  </div>
</div>