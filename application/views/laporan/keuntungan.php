<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Periode</div>
            <div class="card-body">
                <form method="POST" action="<?php echo site_url('laporan/profit_penjualan')?>" id="formPeriode">
                    <div class="form-group">
                        <label>Periode</label>
                        <select class="form-control" name="periode">
                            <option selected="" disabled="">Pilih Periode</option>
                            <?php
                                foreach($tahun as $data){?>
                                    <option value="<?php echo $data->tahun?>"><?php echo $data->tahun?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="btnSubmit" class="btn btn-primary" value="Cari">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <b>Keuntungan Penjualan</b>
            </div>
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',
            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
                datasets: [{
                    label: "Keuntungan Penjualan",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [<?php
                          foreach($keuntungan as $x => $x_value) {
                              echo $x_value.",";
                          }
                        ?>],
                }]
            },

            // Configuration options go here
            options: {}
        });
    })
</script>
