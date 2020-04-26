<?php
    $tabla = "ventas";

    $clientes = ControladorVentas::ctrlComprasCliente($tabla);
?>
<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Compradores</h3>
    </div>
    
    <div class="box-body chart-responsive">
        <div class="chart" id="bar-chart2" style="height: 300px;"></div>
    </div>
</div>

<script>
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart2',
      resize: true,
      data: [
          <?php
          foreach ($clientes as $key => $value) {
              echo "{y: '".$value["cliente"]."', a: ".$value["total_compras"]."},";
          }
           ?>
      ],
      barColors: ['#6666ff'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Total en compras'],
      preUnits: '$',
      hideHover: 'auto'
    });
</script>