    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Pembayaran Simpanan</h3>
            <br>
            <a href="<?php echo base_url('index.php/simpanan/tambah_simpanan')?>" class="btn btn-success"><i class="fa fa-plus-square"></i> Tambah</a>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Perbaharui</button>
            <a href="<?php echo base_url('index.php/simpanan/cetak_pdf')?>" class="btn btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="30">Kode Simpanan</th>
                    <th width="30">Nomor Anggota</th>
                    <th width="180">Nama Anggota</th>
                     <th width="80">Jenis Simpanan</th>
                    <th width="80">Tanggal Simpan</th>
                    <th width="80">Jumlah Simpan</th>
                    <th width="80">Periode</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="30">Kode Simpanan</th>
                <th width="30">Nomor Anggota</th>
                <th width="180">Nama Anggota</th>
                <th width="80">Jenis Simpanan</th>
                <th width="80">Tanggal Simpan</th>
                <th width="80">Jumlah Simpan</th>
                <th width="80">Periode</th>
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
                    "url": "<?php echo site_url('simpanan/read_simpanan')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ 5 ], //last column
                    "orderable": false, //set not orderable
                    "className" : "text-right"
                },
                ],

            });
        });
         function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

    </script>
<!-- test modal -->