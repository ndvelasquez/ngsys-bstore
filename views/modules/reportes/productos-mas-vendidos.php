<?php
    $tabla = "productos";

    $productos = ControladorProductos::ctrlMasVendidos($tabla);
    $totalVentas = $productos[0]["total"];
    $arrayColoresGraficos = array('#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de');
    $arrayColoresLabels = array('red', 'green', 'yellow', 'aqua', 'light-blue', 'gray');
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Productos Más Vendidos</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <div class="chart-responsive">
                    <canvas id="pieChart"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <ul class="chart-legend clearfix">
                    <?php
                        foreach ($productos as $key => $value) {
                            echo '<li><i class="fas fa-circle text-'.$arrayColoresLabels[$key].'"></i> '.$value["descripcion"].'</li>';
                        }
                    ?>
                </ul>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">
            <?php
                foreach ($productos as $key => $value) {
                    echo '<li><a href="#">'.$value["descripcion"].'
                            <span class="pull-right text-'.$arrayColoresLabels[$key].'"><i class="fa fa-angle-down"></i>'.floor($value["ventas"] * 100 / $totalVentas).'%</span>
                            </a>
                          </li>';
                }
            ?>
        </ul>
    </div>
    <!-- /.footer -->
</div>

<script>
   //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          <?php
            foreach ($productos as $key => $value) {
                echo "'".$value["descripcion"]."',";
            }  
          ?> 
      ],
      datasets: [
        {
          data: [
            <?php
            foreach ($productos as $key => $value) {
                echo $value["ventas"].',';
            }  
          ?> 
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      legend: {
        display: false
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

  //-----------------
  //- END PIE CHART -
  //-----------------
</script>