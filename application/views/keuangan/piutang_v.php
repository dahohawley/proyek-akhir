    <div class="row bg-white has-shadow">
        <div class="col-md-12">
            <br>
            <h3>Data Piutang</h3>
            <br>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a href="<?php echo base_url('index.php/keuangan/cetak_pdf_piutang')?>" class="btn btn-info" target="_blank">Cetak PDF</a><br><br>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="80">Kode Penjualan</th>
                    <th width="180">Tanggal Penjualan</th>
                    <th width="80">Telah dibayar</th>
                    <th width="80">Jumlah Transaksi</th>
                    <th width="80">Nama Anggota</th>
                    <th width="80"></th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th width="80">Kode Penjualan</th>
                <th width="180">Tanggal Penjualan</th>
                <th width="80">Telah dibayar</th>
                <th width="80">Jumlah Transaksi</th>
                <th width="80">Nama Anggota</th>
                <th width="80"></th>
                <th width="80"></th>
            </tr>
            </tfoot>
        </table>
    </div>
<!-- AJAX -->
    <script type="text/javascript">
        function showModal(id_penjualan){
            $.ajax({
                url:"<?php echo base_url('index.php/keuangan/detail_piutang/')?>"+id_penjualan,
                type:"GET",
                success:function(data){
                   $("#modal").modal("show");
                   $("#tbody_modal").empty();
                   $("#tbody_modal").append(data);
                }
            })
        }


        var save_method; //for save method string
        var table;
        $(document).ready(function() {
            table = $('#table').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('keuangan/get_piutang')?>",
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
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID Angsuran</td>
                            <td>Tanggal Transaksi</td>
                            <td>Jumlah Bayar</td>
                        </tr>
                    </thead>
                    <tbody id="tbody_modal">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>    