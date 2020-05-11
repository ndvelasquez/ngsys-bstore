<?php
ob_start();

require_once "../../../controllers/cotizaciones.controlador.php";
require_once "../../../models/cotizaciones.modelo.php";

require_once "../../../controllers/clientes.controlador.php";
require_once "../../../models/clientes.modelo.php";


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
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logo-beauty.jpeg" height="100px"></td>

			<td style="background-color:white; width:280px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					RUC: 20603325461

					<br>
					Dirección: Av. La Paz 456, Miraflores, Lima

				</div>

			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>COTIZACIÓN N.<br>$valorCot</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------
$itemCliente = "id";
$valorCliente = $respuestaCotizacion["id_cliente"];
$traerCliente = ControladorClientes::ctrlMostrarClientes($itemCliente, $valorCliente);
$ruc = $traerCliente["documento"];
$direccion = $traerCliente["direccion"];

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px; font-size:8px;">
			Moneda: Soles (S/) <br>
			Forma de pago: 50% adelantado y 50% Contra Entrega <br>
			</td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td colspan="2" style="border: 1px solid #666; background-color:white; width:390px">

				Señores: $cliente <br>
				RUC: $ruc <br>
				Dirección: $direccion

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $vendedor</td>

		</tr>

		<tr>
		
			<td style="background-color:white; width:540px"></td>

		</tr>

		<tr>
			<td style="font-size:8px; background-color:white; width:540px; border-bottom: 1px solid #666">Estimados Señores: De acuerdo a lo solicitado, detallamos a continuación nuestra oferta técnico-económica:</td>
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

$bloque6 = <<<EOF

	<table style="padding:5px 10px;">

		<tr>
			<td style="background-color:white; width:540px; border-bottom: 1px solid #666"></td>
		</tr>

		<tr>

			<td style="border-bottom: 1px solid #666; border-left: 1px solid #666; border-right: 1px solid #666; font-size: 13px; background-color:#ff99cc; width:540px;"><b>Condiciones Generales</b></td>

		</tr>

		<tr>

			<td style="font-size: 8px; width:120px; border: 1px solid #666;">IMPUESTOS</td>
			<td style="font-size: 8px; width:420px; border: 1px solid #666;">Los Precios no incluyen IGV. Impuestos en PERU 18% / expresados en Soles Peruanos.</td>

		</tr>

		<tr>

			<td style="font-size: 8px; width:120px; border: 1px solid #666;">ACEPTACIÓN DE LA COTIZACIÓN</td>
			<td style="font-size: 8px; width:420px; border: 1px solid #666;">La aceptación total o parcial, responde a la selección hecha por el cliente, quién deberá remitir Orden de Compra indicando los ítems, descripción del producto, cantidad, precio unitario y total de los productos por adquirir, haciendo referencia al número de nuestra cotización y fecha.</td>

		</tr>

		<tr>

			<td style="font-size: 8px; width:120px; border: 1px solid #666;">VALIDEZ DE LA OFERTA</td>
			<td style="font-size: 8px; width:420px; border: 1px solid #666;">La presente cotización tiene una validez de 7 días hábiles a partir de la fecha, aplicable solo a la vigencia del precio cotizado.</td>

		</tr>

		<tr>

			<td style="font-size: 8px; width:120px; border: 1px solid #666;">DISPONIBILIDAD</td>
			<td style="font-size: 8px; width:420px; border: 1px solid #666;">Inmediata según Stock y previa coordinacion.</td>

		</tr>

		<tr>

			<td style="font-size: 8px; width:120px; border: 1px solid #666;">GARANTÍA</td>
			<td style="font-size: 8px; width:420px; border: 1px solid #666;">Del representante</td>

		</tr>

		<tr>

			<td style="background-color:white; width:540px;"></td>

		</tr>

		<tr>

			<td style="background-color:white; width:340px; font-size:12px;">
				<b>CUENTAS DE ABONO:</b> <br>
				TITULAR: DINO CORZANO RAMIREZ - RP LEGAL <br>
				BCP SOLES - N° de cuenta: 194-37614545-0-88 <br>
				SCOTIABANK SOLES N° de cuenta: 206-0221229 <br>
			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

// -------------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('cotizacion.pdf', 'I');

}

}

$cotizacion = new imprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();

?>