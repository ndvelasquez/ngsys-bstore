<?php
error_reporting(0);
    if (isset($_GET["fechaInicial"])) {
        $fechaInicial = $_GET["fechaInicial"];
        $fechaFinal = $_GET["fechaFinal"];
      }
      else {
        $fechaInicial = null;
        $fechaFinal = null;
      }

    $ventas = ControladorVentas::ctrlRangoFechasVenta($fechaInicial, $fechaFinal);

    $arrayFechas = array();
    $arrayVentas = array();
    $sumaPagoDia = array();
    foreach ($ventas as $key => $value) {
        if ($value["estado"] != 2) {
            // CAPTURO EL AÑO Y EL MES
            $fecha = substr($value["fecha_creacion"],0,10);
            // INTRODUZCO LAS FECHAS EN EL ARRAY DE FECHAS
            array_push($arrayFechas, $fecha);
            // CAPTURO LAS VENTAS
            $arrayVentas = array($fecha => $value["total"]);
            // SUMO LOS PAGOS TOTALES POR MES
            foreach ($arrayVentas as $key => $totalDia) {
                $sumaPagoDia[$key] += $totalDia;
            }
        }
    }
    $arrayFechas = array_unique($arrayFechas);

?>
<!-- ==============================================
GRAFICO DE VENTAS
=================================================== -->
<div class="box box-solid bg-teal-gradient">

    <div class="box-header">
        <i class="fa fa-th"></i>
        <h3 class="box-title">Gráfico de ventas</h3>
    </div>

    <div class="box-body border-radius-none graficoVentas">
        <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>
    </div>
</div>

<script>
    var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [
      <?php
      if ($arrayFechas != null) {
          foreach ($arrayFechas as $key) {
              echo "{ y: '".$key."', ventas: ".$sumaPagoDia[$key]." },";
          }
          echo "{ y: '".$key."', ventas: ".$sumaPagoDia[$key]." }";
      }
      else {
          echo "{ y: '0', ventas: '0' }";
      }
    ?>
    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['ventas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : 'S/',
    gridTextSize     : 10
  });
</script>