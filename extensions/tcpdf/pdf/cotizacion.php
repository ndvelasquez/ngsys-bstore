<?php
ob_start();

require_once "../../../controllers/cotizaciones.controlador.php";
require_once "../../../models/cotizaciones.modelo.php";

require_once "../../../controllers/productos.controlador.php";
require_once "../../../models/productos.modelo.php";

class imprimirCotizacion{

public $codigo;

public function traerImpresionCotizacion(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemCot = "codigo";
$valorCot = $this->codigo;

$respuestaCotizacion = ControladorCotizaciones::ctrlMostrarCotizaciones($itemCot, $valorCot);

$fecha = substr($respuestaCotizacion["fecha_creacion"],0,-8);
$fecha = date_create($fecha);
$fecha = date_format($fecha, "d/m/Y");
$productos = json_decode($respuestaCotizacion["productos"], true);
$neto = number_format($respuestaCotizacion["neto"],2);
$impuesto = number_format($respuestaCotizacion["impuestos"],2);
$total = number_format($respuestaCotizacion["total"],2);
$cliente = $respuestaCotizacion["cliente"];
$vendedor = $respuestaCotizacion["vendedor"];


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
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					RUC: 20538973431

					<br>
					Dirección: Calle 44B 92-11, Surco, Lima

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					Teléfono: 51 952 285 377
					
					<br>
					ventas@ngsystem.com

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>COTIZACIÓN N.<br>$valorCot</td>

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

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
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
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

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
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Neto:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				S/ $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				IGV:
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				S/ $impuesto
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				S/ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('cotizacion.pdf', 'I');

}

}

$cotizacion = new imprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();

?>