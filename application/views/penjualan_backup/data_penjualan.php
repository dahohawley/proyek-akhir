    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Penjualan</h3>
            <br>
            <a href="<?php echo base_url('index.php/transaksi/tambah_penjualan')?>" class="btn btn-success">Tambah Penjualan</a>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a href="<?php echo base_url('index.php/pembelian/cetak_pdf')?>" class="btn btn-info" target="_blank">Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Penjualan</th>
                    <th width="180">Tanggal</th>
                    <th width="80">Jumlah</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Kode Penjualan</th>
                <th width="180">Tanggal</th>
                <th width="80">Jumlah</th>
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
                    "url": "<?php echo site_url('transaksi/read_penjualan')?>",
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
<!-- test modal -->