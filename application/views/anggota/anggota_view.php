        <h3>Data Anggota </h3>
        <br />
        <button class="btn btn-success" onclick="add_person()"><i class="fa fa-user-plus"></i> Tambah</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Perbaharui</button>
        <a href="<?php echo base_url('index.php/anggota/cetak_pdf')?>" class="btn btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak PDF</a>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">No. Anggota</th>
                    <th width="180">Nama Anggota</th>
                    <th width="80">Alamat</th>
                    <th width="80">Status</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>No. Anggota</th>
                <th>Nama Anggota</th>
                <th>Alamat</th>
                <th>Status</th>
                <th style="width:200px;">Aksi</th>
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
                    "url": "<?php echo site_url('Anggota/LihatAnggota')?>",
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
            $('.modal-title').text('Tambah Anggota'); // Set Title to Bootstrap modal title
            $('#username-group').show();
            $('#password-group').show();
        }

        function edit_person(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('Anggota/GetAnggotaDetail/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id"]').val(data.no_anggota);
                    $('[name="nama"]').val(data.nama);
                    $('[name="alamat"]').val(data.alamat);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Data'); // Set title to Bootstrap modal title
                    $('#username-group').hide();
                    $('#password-group').hide();
                    $('#nama').attr("readonly");
                    $('#alamats').attr("readonly");
                     $('#simpanan-group').hide();
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
                url = "<?php echo site_url('Anggota/TambahAnggota')?>";
            } else {
                url = "<?php echo site_url('Anggota/EditAnggota')?>";
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
                            message: 'Data tersimpan' 
                        },{
                            // settings
                            type: 'info',
                            delay: 2,
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

        function delete_person(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('Anggota/HapusAnggota')?>/"+id,
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
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Anggota</label>
                            <div class="col-md-12">
                                <input name="nama" id="nama"  placeholder="Nama Anggota" class="form-control" type="text" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-12">
                                <input name="alamat" id="alamat" placeholder="Alamat" class="form-control" type="textarea">
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-12">
                                <input name="status" class="form-control" id="status" value="Pegawai" readonly="">
                            </div>
                        </div>-->
                        <div class="form-group" id="simpanan-group">
                            <div class="col-md-12">
                                <input name="tarif" id="tarif" class="form-control" type="hidden" value="<?php echo format_rp($simpanan_pokok)?>" readonly>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Simpan"> 
                        <!-- <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('label.error').hide()">Batal</button>
                    </div>
                </form>
            </div>
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
            maxlength: 30,
            minlength : 3
        },
        alamat: {
            required : true,
            minlength : 5
        },
        status: "required",
        username : {
            required : true,
            maxlength : 30,
            minlength : 3
        },
        password : {
            required : true,
            maxlength : 30,
            minlength : 3
        },
      },
      messages:{
        nama: {
            required: "Nama tidak boleh kosong",
            maxlength: "Nama tidak boleh lebih dari 30 karakter",
            minlength : "Nama tidak boleh kurang dari 3 karakter"
        },
        alamat: {
            required: "Alamat tidak boleh kosong",
            minlength : "Alamat tidak boleh kurang dari 5 karakter"
        },
        status: "Status tidak boleh kosong",
        username : {
            required : "Username tidak boleh kosong",
            maxlength : "Username tidak boleh lebih dari 30 karakter",
            minlength : "Username tidak boleh kurang dari 3 karakter"
        },
        password : {
            required : "Password tidak boleh kosong",
            maxlength : "Password tidak boleh lebih dari 30 karakter",
            minlength : "Password tidak boleh kurang dari 3 karakter"
        },
      },
      submitHandler: function(form) {
        save();
      }
    });
})
</script>
