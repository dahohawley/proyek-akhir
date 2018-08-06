    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Pinjaman</h3>
            <br>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Perbaharui</button>
            <a href="<?php echo base_url('index.php/pinjaman/cetak_pdf')?>" class="btn btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="30">Kode Pinjaman</th>
                    <th width="30">Tanggal Pinjam</th>
                    <th width="100">Nama Anggota</th>
                     <th width="80">Jumlah Pinjam</th>
                    <th width="80">Angsuran Perbulan</th>
                    <th width="80">Jatuh Tempo</th>
                    <th width="80">Status Pinjaman</th>
                    <th width="80">Sisa Pinjaman</th>
                    <th width="110">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="30">Kode Pinjaman</th>
                <th width="30">Tanggal Pinjam</th>
                <th width="100">Nama Anggota</th>
                <th width="80">Jumlah Pinjam</th>
                <th width="80">Angsuran Perbulan</th>
                <th width="80">Jatuh Tempo</th>
                <th width="80">Status Pinjaman</th>
                <th width="80">Sisa Pinjaman</th>
                <th width="110">Aksi</th>
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
                    "url": "<?php echo site_url('pinjaman/read_pinjaman_daftar')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ 3,4,7 ], //last column
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