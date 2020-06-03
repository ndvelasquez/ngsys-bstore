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
$observacion = $respuestaVenta["observacion"];


//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A7');

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>

		<tr>
			<td style="width:160px">
				
				<div style="font-size:8px; text-align:center;">
					
					Fecha: $fecha
					<br>

					<b>BEAUTY PROFESSIONAL STORE EIRL</b>

					<br>
					RUC: 20603325461

					<br>
					Dirección: Av. La Paz 356, Int. 202, Miraflores

					<br>
					Teléfono: +51 952 773 839
					<br>
					&nbsp;&nbsp;&nbsp; +51 990 723 836

					<br>
					RECIBO N°<br> <b>$valorVenta</b>

					<br>
					Vendedor: $vendedor
					<br>
					Cliente: $cliente
					<br>
					Teléfono: $telefono
					<br>
					Dirección de envío: $direccion
					<br>
				</div>

			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque2 = <<<EOF

	<table style="font-size:9px;">

		<tr>	
			<td style="width:160px; text-align:left">
				$item[descripcion]
			</td>
		</tr>

		<tr>
			<td style="width:160px; text-align:left">
			S/ $valorUnitario Und. * $item[cantidad] = $precioTotal
			<br>
			</td>
		</tr>
			
	</table>


EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
}

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:9px; text-align:right">
		
		<tr>

			<td style="width:80px;">
				Neto:
			</td>

			<td style="width:80px;">
				S/ $neto
			</td>

		</tr>

		<tr>

			<td style="width:80px;">
				IGV:
			</td>

			<td style="width:80px;">
				S/ $impuesto
			</td>

		</tr>

		<tr>

			<td style="width:160px;">
				----------------------
			</td>

		</tr>

		<tr>

			<td style="width:80px;">
				TOTAL:
			</td>

			<td style="width:80px;">
				S/ $total
			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('pedido.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>