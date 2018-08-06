        <h3>Data Obyek Alokasi </h3>
        <br />
       <button class="btn btn-success" onclick="add_person()"><i class="fa fa-plus-square"></i> Tambah</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Perbaharui</button>
        <!--<a href="<?php echo base_url('index.php/gudang/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a>-->
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Obyek</th>
                    <th width="180">Nama Obyek</th>
                    <th width="80">Prosentase</th>
                    <th style="width:125px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>Kode Obyek</th>
                <th>Nama Obyek</th>
                <th width="80">Prosentase</th>
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
                    "url": "<?php echo site_url('Obyek/LihatObyek')?>",
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
            $('.modal-title').text('Tambah Obyek'); // Set Title to Bootstrap modal title
        }

        function edit_person(id){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('Obyek/GetObyekDetail/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id"]').val(data.id_obyek);
                    $('[name="nama_obyek"]').val(data.nama_obyek);
                    $('[name="prosentase"]').val(data.prosentase);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Perbarui Data'); // Set title to Bootstrap modal title
                    $('#id-group').hide();
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
                url = "<?php echo site_url('Obyek/TambahObyek')?>";
            } else {
                url = "<?php echo site_url('Obyek/EditObyek')?>";
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
                    url : "<?php echo site_url('Obyek/HapusObyek')?>/"+id,
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
                        <input type="hidden" value="" name="id"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Obyek Alokasi</label>
                            <div class="col-md-12">
                                <input name="nama_obyek" id="nama_obyek"  placeholder="Nama Obyek" class="form-control" type="text" required="">
                            </div>
                            <label class="control-label col-md-3">Prosentase (%)</label>
                            <div class="col-md-12">
                                <input name="prosentase" id="prosentase"  placeholder="Prosentase" class="form-control" type="text" required="">
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
        nama_obyek: {
            required: true,
            maxlength: 50,
            minlength : 3
        },
        prosentase : {
            required : true,
            digits : true,
            max : 100,
            min : 1
        }
      },
      messages:{
        nama_obyek : {
            required : "Nama Obyek tidak boleh kosong.",
            maxlength : "Nama Obyek tidak boleh lebih dari 50 karakter.",
            minlength : "Nama Obyek tidak boleh kurang dari 3 karakter."
        },
        prosentase : {
            required : "Prosentase tidak boleh kosong.",
            digits : "Prosentase hanya diisi angka bulat positif.",
            max : "Prosentase tidak boleh lebih dari 100.",
            min : "Prosentase harus lebih dari 0."
        }
      },
      submitHandler: function(form) {
        save();
      }
    });
})
</script>
