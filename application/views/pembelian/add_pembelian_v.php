<div class="row bg-white has-shadow" id="content">
<div class="col-md-12">
<form id="form" action="#">
   <div class="row">
      <div class="col-md-10">
         <div class="form-group">
            <br>
            <label>Kode Barang</label>
            <div class="form-group">
               <input type="hidden" name="id_pembelian" value="<?php echo $id_pembelian?>">
               <input type="text" name="id_barang" class="form-control" id="id_barang">
            </div>
            <button class="btn btn-primary" id="btnSave" onclick="save()">Tambah</button>
         </div>
      </div>
</form>
<div class="col-md-2">
    <div class="form-group">
        <br>
        <br>
        <button class="btn btn-primary btn-lg" onclick="CariBarang()">Cari barang</button>
    </div>
</div>
<div class="col-md-12">
    <h3>Keranjang</h3>
    <br>
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>subtotal</th>
            <th colspan="2" align="">
            <center>Aksi</center>
            </th>
            </tr>
        </thead>
            <tbody>
            <?php
               $total=0;
                   foreach ($detail_pembelian as $data){
                       $total=$total+$data->subtotal*1;
                       ?>
            <tr>
                <td>
                <?php echo $data->nama_barang?>
                </td>
                <td>
                <?php echo $data->jumlah?>
                </td>
                <td>
                <?php echo format_rp($data->subtotal*1)?>
                </td>
                <td width="80"><button class="btn btn-info" onclick="edit_barang('<?php echo $data->id_pembelian?>',<?php echo $data->id_barang?>)">Edit</button></td>
                <td width="80"><button class="btn btn-danger" onclick="hapus_barang('<?php echo $data->id_pembelian?>',<?php echo $data->id_barang?>)">Hapus</button></td>
            </tr>
            <?php
               }
               ?>
        </tbody>
        <tfoot>
            <tr style="background-color: rgb(200, 247, 197);">
                <td colspan="2"><b>TOTAL</b></td>
                <td colspan="3" id="total_table">
                <?php echo format_rp($total);?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="col-md-12">
<div class="form-group">
<!-- <a href="<?php echo base_url('index.php/pembelian/selesai_pembelian/'.$id_pembelian)?>" class="btn btn-success">Selesai belanja</a>-->
<button class="btn btn-success" onclick="selesai_belanja()">Selesai Belanja</button>
</div>
</div>
</div>
<!-- End Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body form">
            <form action="<?php echo base_url('index.php/pembelian/selesai_pembelian')?>" method="POST" id="form2">
               <div class="form-group">
                  <label>ID Pembelian</label>
                  <input type="text" name="id_pembelian" value="<?php echo $id_pembelian?>" class="form-control" readonly>
               </div>
               <div class="form-group">
                  <label>Supplier</label>
                  <select name="id_supplier" class="form-control" id="id_supplier" placeholder="Pilih ID supplier">
                     <?php
                        foreach ($supplier as $data){?>
                     <option value="<?php echo $data->id_supplier?>"><?php echo $data->nama_supplier?></option>
                     <?php
                        }
                        ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Total yang harus dibayar</label>
                  <input type="text" id="total_modal" name="total" class="form-control" value="" readonly>
               </div>
               <div class="form-group">
                  <label>Total bayar</label>
                  <input type="text" name="total_bayar" id="total_bayar" class="form-control">
               </div>
               <div class="form-group">
                  <input type="submit" name="btnsubmit" class="btn btn-primary" value="Selesai">
               </div>
            </form>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="barang_modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <table id="table_barang" class="table table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th width="80">Kode Barang</th>
                     <th width="180">Nama Barang</th>
                     <th width="80">Harga Beli</th>
                     <th width="80">Harga Jual</th>
                     <th width="80">Stok</th>
                     <th style="width:125px;">Aksi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
               <tfoot>
                  <tr>
                     <th>Kode Barang</th>
                     <th>Nama Barang</th>
                     <th>Harga Beli</th>
                     <th>Harga Jual</th>
                     <th>Stok</th>
                     <th>Aksi</th>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edit_jumlah" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Jumlah</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
         <form class="form-horizontal" action="#" id="form_detail">
         	<input type="hidden" name="id_pembelian">
         	<input type="hidden" name="id_barang_modal">
			<div class="form-group">
				<label>Nama Barang</label>
				<input type="text" name="nama_barang" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label>Jumlah</label>
				<input type="text" name="jumlah" class="form-control">
			</div>
			<div class="form-group">
				<input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpa"
			</div>
         </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<!-- external script -->
<script type="text/javascript">
   var baseURL = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url('assets/js/pembelian_script.js')?>"></script>