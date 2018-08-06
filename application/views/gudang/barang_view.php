    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data barang </h3>
            <br>
            <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Tambah Barang</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a href="<?php echo base_url('index.php/gudang/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">ID Barang</th>
                    <th width="180">Nama Barang</th>
                    <th width="80">Harga Beli</th>
                    <th width="80">Harga Jual</th>
                    <th width="80">Jenis Barang</th>
                    <th width="80">Stok</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Jenis Barang</th>
                <th>Stok</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
<!-- AJAX -->
    <script type="text/javascript">
        var save_method; //for save method string
        var table;
        $(document).ready(function() {
            table = $('#table').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('gudang/ajax_list')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                ],

            });
        });
        function add_barang(){
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Barang'); // Set Title to Bootstrap modal title
            $('[name="nama_barang"]').focus();
        }

        function edit_barang(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('gudang/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id"]').val(data.id_barang);
                    $('[name="barcode"]').val(data.id_barang);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="harga_beli"]').val(data.harga_beli);
                    $('[name="harga_jual"]').val(data.harga_jual);
                    $('[name="jenis_barang"]').val(data.jenis_barang);
                    $('[name="stok"]').val(data.stok);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Barang'); // Set title to Bootstrap modal title

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }

        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

        function save(){

            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;
            if(save_method == 'add') {
                url = "<?php echo site_url('gudang/ajax_add')?>";
            } else {
                url = "<?php echo site_url('gudang/ajax_update')?>";
            }

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }

                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $.notify({
                        // options
                        message: 'Data Tersimpan' 
                    },{
                        // settings
                        type: 'info',
                        delay:2,
                        placement: {
                            from: "top",
                            align: "center"
                        },
                    }); 
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    var harga_beli = $("#harga_beli").val();
                    var harga_jual = $("#harga_jual").val();
                    alert("Tejadi kesalahan saat menambahkan data");
                    if(harga_jual < harga_beli){
                        alert("Harga jual tidak bisa lebih kecil dari harga beli");
                    }
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        }

        function delete_barang(id){
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('gudang/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                        $.notify({
                            // options
                            message: 'Data terhapus' 
                        },{
                            // settings
                            type: 'danger',
                            delay: 2,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        }); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }
    </script>
<!-- test modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <form id="form" action="#" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama barang</label>
                            <div class="col-md-12">
                                <input name="nama_barang" id="nama_barang"  placeholder="Nama Barang" class="form-control" type="text" required="">
                                <i id="nama_barang_message"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Barcode</label>
                            <div class="col-md-12">
                                <input name="barcode" id="barcode"  placeholder="Barcode" class="form-control" type="text" required="">
                                <i id="barcode_message"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga beli</label>
                            <div class="col-md-12">
                                <input name="harga_beli" id="harga_beli" placeholder="Harga Beli" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga jual</label>
                            <div class="col-md-12">
                                <input name="harga_jual" id="harga_jual" placeholder="Harga Jual" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Barang</label>
                            <div class="col-md-12">
                                <select name="jenis_barang" class="form-control" id="jenis_barang">
                                    <option value="">--Pilih jenis--</option>
                                    <option value="KLT">Kelontong</option>
                                    <option value="KSM">Konsumsi</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Stok</label>
                            <div class="col-md-12">
                                <input name="stok" placeholder="Stok" class="form-control" id="stok" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan"> 
                        <!-- <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('label.error').hide()">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script src="<?php echo base_url('assets/js/validate.js')?>"></script>
