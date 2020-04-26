<?php
  $tabla = "ventas";

  $vendedores = ControladorVentas::ctrlVentasPorVendedor($tabla);
?>

<div class="box box-success">

    <div class="box-header with-border">
        <h3 class="box-title">Vendedores</h3>
    </div>
    
    <div class="box-body chart-responsive">
        <div class="chart" id="bar-chart1" style="height: 300px;"></div>
    </div>
</div>

<script>
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart1',
      resize: true,
      data: [
        <?php
        foreach ($vendedores as $key => $value) {
          echo "{y: '".$value["vendedor"]."', a: ".$value["total_ventas"]."},";
        }
        ?>
      ],
      barColors: ['#80ff80'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['VENTAS'],
      preUnits: 'S/',
      hideHover: 'auto'
    });
</script>