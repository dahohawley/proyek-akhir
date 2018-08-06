        <h3>Data Pengurus </h3>
        <br />
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Tambah Pengurus</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <a href="<?php echo base_url('index.php/gudang/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Pengurus</th>
                    <th width="180">Nama Pengurus</th>
                    <th width="80">Alamat</th>
                    <th width="80">Posisi</th>
                    <th style="width:125px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Kode Pengurus</th>
                <th width="180">Nama Pengurus</th>
                <th width="80">Alamat</th>
                <th width="80">Posisi</th>
                <th style="width:125px;">Aksi</th>
            </tr>
            </tfoot>
        </table>
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
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
                    "url": "<?php echo site_url('Pengurus/ajax_list')?>",
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
        function add_person(){
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Pengurus'); // Set Title to Bootstrap modal title
        }

        function edit_person(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('Pengurus/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="id"]').val(data.id_pengurus);
                    $('[name="nama"]').val(data.nama);
                    $('[name="alamat"]').val(data.alamat);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Data'); // Set title to Bootstrap modal title
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
                url = "<?php echo site_url('Pengurus/ajax_add')?>";
            } else {
                url = "<?php echo site_url('Pengurus/ajax_update')?>";
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
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 

                }
            });
        }

        function delete_person(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('Pengurus/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }
    </script>
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
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Pengurus</label>
                            <div class="col-md-12">
                                <input name="nama" id="nama"  placeholder="Nama Pengurus" class="form-control" type="text" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-12">
                                <input name="alamat" id="alamat" placeholder="Alamat" class="form-control" type="textarea">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Username</label>
                            <div class="col-md-12">
                                <input name="username" id="username" placeholder="Username" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-12">
                                <input name="password" id="password" placeholder="Password" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Posisi</label>
                            <div class="col-md-12">
                                <select name="posisi" id="posisi" class="form-control">
                                    <option value="" selected="">Pilih Posisi</option>
                                    <option value="1">Ketua</option>
                                    <option value="2">Bendahara</option>
                                    <option value="3">Kasir</option>
                                </select>
                            </div>
                        </div>
                    </div>   
                </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan"> 
                        <!-- <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('label.error').hide()">Batal</button>
                    </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    $("#form" ).validate({
      rules: {
        nama: {
            required: true,
            maxlength: 50
        },
        posisi: "required",
        alamat: "required",
        username: "required",
        password: "required",
      },
      messages:{
        nama: {
            required: "Nama tidak boleh kosong.",
            maxlength: "Nama tidak boleh lebih dari 50 karakter"
        },
        alamat: "Alamat tidak boleh kosong",
        posisi: "Posisi tidak boleh kosong",
        username: "Username tidak boleh kosong",
        password: "Password tidak boleh kosong"
      },
      submitHandler: function(form) {
        save();
      }
    });
})
</script>
