<?php
ob_start();

require_once "../../../controllers/productos.controlador.php";
require_once "../../../models/productos.modelo.php";

class imprimirFactura{


public function traerImpresionFactura(){

// TRAIGO LA INFORMACION DEL PRODUCTO
$itemProducto = null;
$valorProducto = null;

$respuestaProducto = ControladorProductos::ctrlMostrarProductos($itemProducto, $valorProducto);


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

			<td style="background-color:white; width:110px;"></td>

        </tr>
        
        <tr>
            <td style="width: 540px;">
                <div style="font-size: 15px; text-align: center">
                    LISTA DE PRECIOS
                </div>
            </td>
        </tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
        <td style="border: 1px solid #666; background-color:white; width:60px; text-align:center">Código</td>
        <td style="border: 1px solid #666; background-color:white; width:280px; text-align:center">Descripción</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Categoría</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Prec. Venta</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($respuestaProducto as $key => $item) {

$precioCompra = number_format($item["precio_compra"], 2);
$precioVenta = number_format($item["precio_venta"], 2);

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
            
            <td style="border: 1px solid #666; color:#333; background-color:white; width:60px; text-align:center">
            $item[codigo]
            </td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:280px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$item[categoria]
			</td>


			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/ 
				$precioVenta
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}


// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('productos.pdf', 'I');

}

}

$factura = new imprimirFactura();
$factura -> traerImpresionFactura();

?>