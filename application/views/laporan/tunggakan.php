        <h3>Daftar Tunggakan</h3>
        <br />
        <a href="<?php echo base_url('index.php/gudang/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">No. Anggota</th>
                    <th width="180">Nama Anggota</th>
                    <th width="80">Wajib</th>
                    <th width="80">Manasuka</th>
                    <th width="80">Hari Raya</th>
                    <th width="80">Pendidikan</th>
                    <th width="80">Angsuran</th>
                    <th width="80">Jasa</th>
                    <th width="80">Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">No. Anggota</th>
                <th width="180">Nama Anggota</th>
                <th width="80">Wajib</th>
                <th width="80">Manasuka</th>
                <th width="80">Hari Raya</th>
                <th width="80">Pendidikan</th>
                <th width="80">Angsuran</th>
                <th width="80">Jasa</th>
                <th width="80">Total</th>
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
                    "url": "<?php echo site_url('Laporan/LihatTunggakan')?>",
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
    </script>
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
