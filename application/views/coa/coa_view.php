    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data COA</h3>
            <br>
            <button class="btn btn-success" onclick="add_coa()"><i class="glyphicon glyphicon-plus"></i> Tambah COA</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a href="<?php echo base_url('index.php/coa/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Akun</th>
                    <th width="180">Nama Akun</th>
                    <!-- <th width="80">Saldo</th>
                    <th style="width:125px;">Action</th> -->
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Kode Akun</th>
                <th width="180">Nama Akun</th>
                <!-- <th width="80">Saldo</th>
                <th>Action</th> -->
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
                    "url": "<?php echo site_url('coa/ajax_list')?>",
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
        function add_coa(){
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah COA'); // Set Title to Bootstrap modal title
            $('[name="no_akun"]').removeAttr("readonly");

        }
        function edit_coa(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('coa/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="no_akun"]').val(data.no_akun);
                    $('[name="nama_akun"]').val(data.nama_akun);
                    $('[name="saldo"]').val(data.saldo);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Barang'); // Set title to Bootstrap modal title
                    $('[name="no_akun"]').attr("readonly",'true');
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
                url = "<?php echo site_url('coa/ajax_add')?>";
            } else {
                url = "<?php echo site_url('coa/ajax_update')?>";
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
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 

                }
            });
        }

        function delete_coa(id){
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('coa/ajax_delete')?>/"+id,
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
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Akun</label>
                            <div class="col-md-12">
                                <input name="no_akun" id="no_akun"  placeholder="Kode Akun" class="form-control" type="text" required="">
                                <i id="no_akun_message"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Akun</label>
                            <div class="col-md-12">
                                <input name="nama_akun" id="nama_akun" placeholder="Nama Akun" class="form-control" type="text">
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
<script type="text/javascript">
    $(function(){
        $("#form" ).validate({
          rules: {
            nama_akun:{
                required : true,
                maxlength : 30
            },
            no_akun: {
                required: true,
                number: true
            },
          },
          messages:{
            nama_akun: {
                required :"Nama akun tidak boleh kosong.",
                maxlength : "Nama akun tidak boleh lebih dari 30 Karakter"
            },
            no_akun: {
                required: "Kode Akun tidak boleh kosong.",
                number: "Kode Akun hanya bisa diisi oleh angka."
            },
          },
          submitHandler: function(form) {
            save();
          }
        });
    })
</script>
