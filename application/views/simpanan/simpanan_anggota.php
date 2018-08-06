    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Simpanan Anggota </h3>
            <br>
            <button class="btn btn-success" onclick="add_person()"><i class="fa fa-pencil"></i> Daftar</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Perbaharui</button>
            <!--<a href="<?php echo base_url('index.php/gudang/cetak_pdf')?>" class="btn btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak PDF</a><br><br>-->
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Nomor Anggota</th>
                    <th width="180">Nama Anggota</th>
                    <th width="80">Simpanan</th>
                    <th width="80">Tarif</th>
                    <th width="80">Jumlah Simpanan</th>
                    <th width="80">Tanggal Ambil</th>
                    <th style="width:125px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Nomor Anggota</th>
                <th width="180">Nama Anggota</th>
                <th width="80">Simpanan</th>
                <th width="80">Tarif</th>
                <th width="80">Jumlah Simpanan</th>
                <th width="80">Tanggal Ambil</th>
                <th style="width:125px;">Aksi</th>
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
                    "url": "<?php echo site_url('datasimpanan/LihatData')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                
                "columnDefs": [
                { 
                    "targets": [ 3,4], //last column
                    "orderable": false, //set not orderable
                    "className" : "text-right"
                },
                ],

            });
        });
        function add_person(){
             $('[name="no_anggota"]').removeAttr("readonly");
             $('[name="id_jenis"]').removeAttr("readonly");
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Daftar Simpanan'); // Set Title to Bootstrap modal title
            $('[name="nama_barang"]').focus();
        }

        function edit_simpanan(no_anggota,id_jenis,tarif,tgl_ambil){
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('datasimpanan/EditData/')?>/" + no_anggota +'/'+ id_jenis,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="no_anggota"]').attr("readonly",'readonly');
                    $('[name="id_jenis"]').attr("readonly",'readonly');
                    $('[name="no_anggota"]').val(data.no_anggota);
                    $('[name="id_jenis"]').val(data.id_jenis);
                    $('[name="tarif"]').val(data.tarif);
                    $('[name="tgl_ambil"]').val(data.tgl_ambil);
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
                url = "<?php echo site_url('datasimpanan/TambahData')?>";
            } else {
                url = "<?php echo site_url('datasimpanan/UpdateData')?>";
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

        function get_jenis(no_anggota){
            $.ajax({
            url: "<?php echo base_url('index.php/datasimpanan/get_simpanan_angg/')?>"+no_anggota,
            type: "GET",
            success: function(data){
                $("#tarif").val("");
                $("#id_jenis").html("");
                $("#id_jenis").append('<option disabled="" selected="">Pilih Simpanan</option>');
                $("#id_jenis").append(data);
            }
        })
        }

        function delete_simpanan(no_anggota,id_jenis){
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('datasimpanan/DeleteData')?>/"+no_anggota+'/'+id_jenis,
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
                <form id="form" action="<?php echo site_url('datasimpanan/TambahData')?>" method="POST" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Anggota</label>
                            <div class="col-md-12">
                               <select name="no_anggota" class="form-control" id="no_anggota" onchange="get_jenis(this.value)">
                                    <option disabled="" selected="" id="pilih_anggota">Pilih Anggota</option>
                                     <?php
                                    foreach ($anggota as $data) {?>
                                      <option value="<?php echo $data->no_anggota?>"><?php echo $data->nama?></option> 
                                 <?php } 
                                ?>                                            
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Simpanan</label>
                            <div class="col-md-12">
                                <select name="id_jenis" id="id_jenis" class="form-control">
                                <option selected="" disabled="" id="pilih_jenis">Pilih Simpanan</option>
                                <?php
                                    foreach ($jenis as $data) {?>
                                      <option value="<?php echo $data->id_jenis?>"><?php echo $data->keterangan?></option> 
                                 <?php } 
                                ?>         
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tarif</label>
                            <div class="col-md-12">
                                <input name="tarif" id="tarif" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <?php
                            $date = new DateTime();
                            $date->modify("+1 day");
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Ambil</label>
                            <div class="col-md-12">
                                <input name="tgl_ambil" id="tgl_ambil" class="form-control" type="date" min="<?php echo $date->format("Y-m-d");?>">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Daftar"> 
                        <!-- <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('label.error').hide()">Batal</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->
<script src="<?php echo base_url('assets/selectize/dist/js/selectize.js')?>"></script>
<script type="text/javascript">
</script>
<script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
<script>
    $(function(){
    var yyyy = (new Date()).getFullYear();
    $("#form" ).validate({
      rules: {
        no_anggota: "required",
        id_jenis : "required",
        tarif : {
            required : true,
            digits : true,
            maxlength : 11,
            min : 1000
        },
      },
      messages:{
        no_anggota : "Nama Anggota tidak boleh kosong.",
        id_jenis : "Simpanan tidak boleh kosong.",
        tarif : {
            required : "Tarif tidak boleh kosong.",
            digits : "Tarif hanya diisi oleh angka bulat positif.",
            maxlength : "Tarif tidak boleh lebih dari 11 karakter.",
            min : "Tarif minimal adalah Rp 1.000,-"
        }
      }
    });
})
</script>

