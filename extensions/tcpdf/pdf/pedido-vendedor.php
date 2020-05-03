<?php
ob_start();

require_once "../../../controllers/ventas.controlador.php";
require_once "../../../models/ventas.modelo.php";

require_once "../../../controllers/productos.controlador.php";
require_once "../../../models/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrlMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha_creacion"],0,-8);
$fecha = date_create($fecha);
$fecha = date_format($fecha, "d/m/Y");
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuestos"],2);
$total = number_format($respuestaVenta["total"],2);
$cliente = $respuestaVenta["cliente"];
$telefono = $respuestaVenta["telefono"];
$direccion = $respuestaVenta["direccion"];
$vendedor = $respuestaVenta["vendedor"];


//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logo-beauty.jpeg"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:10px; text-align:right; line-height:15px;">
					
					<br>
					RUC: 20603325461

					<br>
					Dirección: Av. La Paz 356, Int. 202, Miraflores

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:10px; text-align:right; line-height:15px;">
					
					<br>
					Teléfono: +51 952 773 839
					<br>
					&nbsp;&nbsp; +51 990 723 836

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>RECIBO N°<br>$valorVenta</td>

		</tr>

		<tr>
			<td style="background-color:#ff99cc; font-size: 20px; line-height:20px; width:540px; text-align:center; color:white">Detalle de compra</td>
		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $cliente
				<br>
				Teléfono: $telefono
				<br>
				Dirección de envío: $direccion

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:center;">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $vendedor</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:460px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {
$tablaProducto = "productos";
$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];

// $respuestaProducto = ControladorProductos::ctrlMostrarProductos($tablaProducto,$itemProducto, $valorProducto);

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:460px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}


// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('pedido.pdf', 'I');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>