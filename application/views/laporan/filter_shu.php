<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Filter
      </div>
      <div class="card-body">
        <form class="form-inline" action="<?php echo base_url('index.php/Laporan/pembagian_shu/')?>" method="POST">
          <div class="form-group"> 
            <select class="mx-sm-3 form-control" id="unit" name="unit">
              <option selected="" disabled="" >Pilih Unit</option>
              <option value="1">Simpan Pinjam</option>
              <option value="2">Toko</option>
              <option value="3">Semua</option>
            </select>
          </div>
          <div class="form-group">
          <input type="submit" value="Tampilkan" class="mx-sm-3 btn btn-primary">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>