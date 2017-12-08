
    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Utang</h3>
            <br>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a href="<?php echo base_url('index.php/keuangan/cetak_pdf_utang')?>" class="btn btn-info" target="_blank">Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Pembelian</th>
                    <th width="180">Tanggal Pembelian</th>
                    <th width="80">Jumlah Angsuran</th>
                    <th width="80">Jumlah Transaksi</th>
                    <th width="80">Pemasok</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Kode Pembelian</th>
                <th width="180">Tanggal Pembelian</th>
                <th width="80">Jumlah Angsuran</th>
                <th width="80">Jumlah Transaksi</th>
                <th width="80">Pemasok</th>
                <th width="80">Action</th>
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
                    "url": "<?php echo site_url('keuangan/get_utang')?>",
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
         function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

    </script>
    