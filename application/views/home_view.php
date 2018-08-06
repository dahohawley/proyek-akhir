<section class="dashboard-counts no-padding-bottom">
    <div class="container-fluid">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-6 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-money"></i></div>
                    <div class="title"><span>Total<br>Penjualan</span>
                    </div>
                    <div class="number"><strong><?php echo format_rp($total_penjualan)?></strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-6 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="fa fa-exchange"></i></div>
                    <div class="title"><span>Total<br>Pembelian</span>
                    </div>
                    <div class="number"><strong><?php echo format_rp($total_pembelian)?></strong></div>
                </div>
            </div>
            <!-- Item -->
        </div>
    </div>
</section>

<!-- chart -->
<section class="dashboard-header">
    <div class="container-fluid">
        <div class="row">
            <!-- Statistics -->
            <div class="statistics col-lg-3 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-barcode"></i></div>
                    <div class="text"><strong><?php echo $jumlah_barang?></strong><br><small>Jumlah Barang</small></div>
                </div>
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-user"></i></div>
                    <div class="text"><strong><?php echo $jumlah_anggota?></strong><br><small>Jumlah Anggota</small></div>
                </div>
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-user"></i></div>
                    <div class="text"><strong>147</strong><br><small>Forwards</small></div>
                </div>
            </div>
            <div class="col-lg-6">
              <div class="line-chart-example card">
                  <div class="card-close">
                      <div class="dropdown">
                          <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                          <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                      </div>
                  </div>
                  <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Penjualan & Pembelian</h3>
                  </div>
                  <div class="card-body"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                      <canvas id="lineChartExample" width="799" height="399" style="display: block; width: 799px; height: 399px;"></canvas>
                  </div>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="checklist card">
                <div class="card-close">
                    <div class="dropdown">
                        <button type="button" id="closeCard5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard5" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center">
                    <h2 class="h3">Barang Hampir Habis</h2>
                </div>
                <div class="card-body no-padding">
                  <div class="col-md-12">
                    <?php
                      $jumlah_data = count($barang_habis);
                      if($jumlah_data <= 0){
                        echo "<br><br><br><br><center><h4>Stok barang dagang tercukupi <i class='fa fa-check'></i><h4></center><br>
                        <br>
                        <br>
                        <br>";
                      }else{?>
                          <table class="table table-hover table-bordered">
                            <tr>
                              <th>Nama Barang</th>
                              <th>Sisa Stok</th>
                            </tr>
                            <?php
                              foreach($barang_habis as $data){?>
                              <tr>
                                <td><?php echo $data->nama_barang?></td>
                                <td><?php echo $data->stok?></td>
                              </tr>
                            <?php
                              }
                            ?>
                          </table>
                      <?php
                      }
                    ?>
                </div>
              </div>
            </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
  /*global $, document*/
  $(document).ready(function(){

    'use strict';


    // ------------------------------------------------------- //
    // Charts Gradients
    // ------------------------------------------------------ //
    var ctx1 = $("canvas").get(0).getContext("2d");
    var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
    gradient1.addColorStop(0, 'rgba(133, 180, 242, 0.91)');
    gradient1.addColorStop(1, 'rgba(255, 119, 119, 0.94)');

    var gradient2 = ctx1.createLinearGradient(146.000, 0.000, 154.000, 300.000);
    gradient2.addColorStop(0, 'rgba(104, 179, 112, 0.85)');
    gradient2.addColorStop(1, 'rgba(76, 162, 205, 0.85)');


    // ------------------------------------------------------- //
    // Line Chart
    // ------------------------------------------------------ //
    var LINECHARTEXMPLE   = $('#lineChartExample');
    var lineChartExample = new Chart(LINECHARTEXMPLE, {
        type: 'line',
        options: {
            legend: {labels:{fontColor:"#777", fontSize: 12}},
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }]
            },
        },
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli","Agustus",'September','Oktober','November','Desember'],
            datasets: [
                {
                    label: "Penjualan",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: gradient1,
                    borderColor: gradient1,
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: gradient1,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: gradient1,
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [
                        <?php
                          foreach($chart_penjualan as $x => $x_value) {
                              echo $x_value.",";
                          }
                        ?>
                          ],
                    spanGaps: false
                },
                {
                    label: "Pembelian",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: gradient2,
                    borderColor: gradient2,
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: gradient2,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: gradient2,
                    pointHoverBorderColor: "rgba(220,220,225,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [
                        <?php
                          foreach($chart_pembelian as $x => $x_value) {
                              echo $x_value.",";
                          }
                        ?>
                          ],
                    spanGaps: false
                }
            ]
        }
    });
  });
</script>