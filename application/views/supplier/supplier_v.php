    <div class="row bg-white has-shadow">
        <div class="col-md-12">
        <br><br>
        <h3>Data supplier </h3>
        <br />
        <button class="btn btn-success" onclick="add_supplier()"><i class="glyphicon glyphicon-plus"></i> Tambah supplier</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <a href="<?php echo base_url('index.php/supplier/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a>
        <br />
        <br />
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">ID supplier</th>
                    <th width="180">Nama supplier</th>
                    <th width="80">Alamat</th>
                    <th width="80">Nomor Telepon</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>ID supplier</th>
                <th>Nama supplier</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
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
                    "url": "<?php echo site_url('supplier/ajax_list')?>",
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
        function add_supplier(){
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah supplier'); // Set Title to Bootstrap modal title
        }

        function edit_supplier(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('supplier/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="id_supplier"]').val(data.id_supplier);
                    $('[name="nama_supplier"]').val(data.nama_supplier);
                    $('[name="alamat"]').val(data.alamat);
                    $('[name="telp"]').val(data.telp);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui supplier'); // Set title to Bootstrap modal title

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
                url = "<?php echo site_url('supplier/ajax_add')?>";
            } else {
                url = "<?php echo site_url('supplier/ajax_update')?>";
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
                            tittle: 'Hapus data supplier',
                            icon: 'ti ti-check-box',
                            message: 'Data berhasil disimpan<br />' 
                        },{
                            // settings
                            placement:{
                                align:'center'
                            },
                            delay: "20",
                            type: 'success'
                        }); 
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 

                }
            });
        }

        function delete_supplier(id){
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('supplier/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                        //$.notify("supplier terhapus.");
                        //NOTIFY
                        $.notify({
                            // options
                            tittle: 'Hapus data supplier',
                            icon: 'glyphicon glyphicon-warning-sign',
                            message: 'Data berhasil dihapus <br />' 
                        },{
                            // settings
                            placement:{
                                align:'center'
                            },
                            delay: "20",
                            type: 'danger'
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
                <h3 class="modal-title">Form supplier</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama supplier</label>
                            <div class="col-md-12">
                                <input name="nama_supplier" id="nama_supplier"  placeholder="Nama supplier" class="form-control" type="text" required="">
                                <i id="nama_supplier_message"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-12">
                                <input name="alamat" id="alamat" placeholder="Alamat" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Telp</label>
                            <div class="col-md-12">
                                <input name="telp" id="telp" placeholder="Nomor Telepon" class="form-control" type="text">
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
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script type="text/javascript">
    $(function(){
        $("#form" ).validate({
          rules: {
            nama_supplier: {
                required : true,
                maxlength : 30
            },
            telp: {
                required: true,
                number: true
            },
          },
          messages:{
            nama_supplier:{
             required :"Nama Supplier tidak boleh kosong.", 
             maxlength : "Nama Supplier tidak lebih dari 31 karakter." 
            },
            telp:{
                required: "Nomor Telepon tidak boleh kosong.",
                number: "Nomor Telepon hanya dapat diisi dengan angka."
            },
          },
          submitHandler: function(form) {
            save();
          }
        });
    })
</script>