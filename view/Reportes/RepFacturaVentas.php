<?php

session_start();
require_once 'controlador/actores/C_Cliente.php';
require_once 'controlador/facturas/C_FacturaVentas.php';

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    require 'fpdf/fpdf.php';

    //require_once 'modelo/ConexDB/conexionMYSQL.php';

    class PDF extends FPDF {

// Cabecera de página
        function Header() {
            // Logo
            //   $this->Image('curso.jpg', 10, 8, 33);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Movernos a la derecha
            $this->Cell(50);
            // Título
            // $this->Cell(50, 10, 'SYSCOMANDES', 0, 0, 'C');
            // Salto de línea
            $this->Ln(10);
        }

// Pie de página
        function Footer() {
            // Posición: a 1,5 cm del final
            //  $this->SetY(-15);
            // Arial italic 8
            //  $this->SetFont('Arial', 'I', 8);
            // Número de página
            // $this->Cell(0, 5, 'Pag ' . $this->PageNo() . '/{nb}  sofw syscom', 0, 0, 'C');
        }

        // Cargar los datos
        function LoadData($file) {
            // Leer las líneas del fichero
            $lines = file($file);
            $data = array();
            foreach ($lines as $line)
                $data[] = explode(';', trim($line));
            return $data;
        }

        // Tabla simple
        function BasicTable($header, $data) {
            // Cabecera
            foreach ($header as $col)
                $this->Cell(45, 7, $col, 1);
            $this->Ln();
            // Datos
            foreach ($data as $row) {
                foreach ($row as $col)
                    $this->Cell(45, 6, $col, 1);
                $this->Ln();
            }
        }

        function FancyTable($header, $data) {
            // Colores, ancho de línea y fuente en negrita
            $this->SetFillColor(0, 125, 255);
            $this->SetTextColor(255);
            //Color de Linea
            $this->SetDrawColor(255, 255, 255);
            $this->SetLineWidth(.01);

            $this->SetFont('', 'B', '8.5');
            // Cabecera - anchos de c/columna
            $w = array(27, 55, 23, 23);

            for ($i = 0; $i < count($header); $i++)
                $this->Cell($w[$i], 6.75, $header[$i], 0, 0, 'C', false);
            $this->Ln();
            // Restauración de colores y fuentes
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Datos
            $fill = false;
            $b = 5.151;
            if ($data != null) {
                foreach ($data as $row) {
                    $this->Cell($w[0], $b, $row[1], 'LR', 0, 'C', false);
                    $this->Cell($w[1], $b, $row[2], 'LR', 0, 'L', false);
                    $this->Cell($w[2], $b, round(($row[3] - $row[3] * $row[4]), 4), 'LR', 0, 'R', false);
                    $this->Cell($w[3], $b, round((round(($row[1] * $row[3]), 2) - round(($row[1] * $row[3]), 2) * $row[4]), 2), 'LR', 0, 'R', false);
                    $this->Ln();
                    $fill = !$fill;
                }
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
        }

    }

// Creación del objeto de la clase heredada
    $pdf = new PDF('P', 'mm', array(220, 148));


// Títulos de las columnas
    $header = array('CANTIDAD', 'DESCRIPCION', 'P. UNITARIO', 'P. TOTAL');

//para obtener datos desde mysql 
    /*     * *************************************************** */

    $factura = NULL;

    $data0 = null;
    $data = NULL;
    $data1 = null;
    $conex = new conexionMYSQL();
    $conex->conectar();
    /* ------------------------------CABECERA DE FACTURA--------------------------- */

    $nObj = new C_FacturaVentas();
    $data0 = $nObj->FacturaActivada();

    if ($data0 != NULL) {
        foreach ($data0 as $fila) {
            $factura = $fila[7];
        }
    }

    /* --------------DETALLE DE FACTURA-------------------- */

    $nObj = new C_FacturaVentas();
    $data = $nObj->detalle_factura_ventas($factura);

    /* ----------------------------TOTALES DE FACTURTA-------------------- */
    $data1 = $nObj->total_factura_ventas();
    $descuento = $nObj->descuento_factura_ventas();


    /*     * *************************************************** */
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(10, 0, 5);


    /* -------CABECERA DE FACTURA------------- */

    $pdf->SetFont('Times', '', 10);
    $pdf->Ln(22);
    $a = 7.45;

    foreach ($data0 as $row) {

        //CLIENTE
        $pdf->SetXY(35, 41);
        $pdf->Cell(0, $a, $row[0], 0, 1);
        //RUC/CI
        $pdf->SetXY(35, 48.75);
        $pdf->Cell(40, $a, $row[1], 0);
        //TELF
        $pdf->Cell(80, $a, $row[3], 0, 1, 'C');

        //DIRECCION
        $pdf->SetXY(35, 56.20);
        $pdf->Cell(0, $a, $row[4], 0, 1);
        //LUGAR Y FELCHA
        $pdf->SetXY(35, 64);
        $pdf->Cell(0, $a, 'Riobamba,' . date('m.d.y'), 0);
        $pdf->Ln();
    }



    /* -------DETALLE DE  FACTURA------------- */
    $pdf->FancyTable($header, $data);


    /* -------PIE DE FACTURA------------------- */
    $pdf->SetFont('Times', '', 10);
    $posX = 125;
//Subtotal
    $pdf->SetXY(10, 166);
    $pdf->Cell($posX, 5, round(($data1['total'] / 1.14), 2), 0, 1, 'R');
//Descuento
    $pdf->SetXY(10, 171);
    $pdf->Cell($posX, 5, round($descuento['descuento'] - $data1['total'], 2), 0, 1, 'R');
// T. IVA 0%
    $pdf->SetXY(10, 176.75);
    $pdf->Cell($posX, 5, '0.00', 0, 1, 'R');
// T. IVA 14%
    $pdf->SetXY(10, 182.5);
    $pdf->Cell($posX, 5, round(($data1['total'] / 1.14), 2), 0, 1, 'R');
// Importe del Iva 14%
    $pdf->SetXY(10, 188.25);
    $pdf->Cell($posX, 5, round((round($data1['total'], 2) - round(($data1['total'] / 1.14), 2)), 2), 0, 1, 'R');
    $pdf->SetXY(10, 194);
//Total
    $pdf->Cell($posX, 5, round($data1['total'], 2), 0, 1, 'R');

    $pdf->Output();
}    