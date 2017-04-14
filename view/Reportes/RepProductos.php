<?php



//require_once 'extras/PHPpdf/fpdf.php';
require './fpdf/fpdf.php';
require_once '../../modelo/ConexDB/conexionMYSQL.php';

class PDF extends FPDF {

// Cabecera de página
    function Header() {
        // Logo
       // $this->Image('curso.jpg', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(50);
        // Título
        $this->Cell(80, 10, 'SYSCOMANDES - LISTADO DE PRODUCTOS', 0, 0, 'C');
        // Salto de línea
        $this->Ln(10);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pag ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
        $this->SetDrawColor(0, 75, 255);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera - anchos de c/columna
        $w = array(10,30, 30,70,30);

        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 5, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 5, $row[1], 'LR', 0, 'L', $fill);            
            $this->Cell($w[2], 5, $row[3], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 5, $row[4], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 5, $row[6], 'LR', 0, 'L', $fill);
            
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}

// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', 'A4');

// Títulos de las columnas
$header = array('ID', 'Cod. BARRAS', 'CATEGORIA', 'PRODUCTO','MARCA');

// Carga de datos
//$data = $pdf->LoadData('paises.txt');


//para obtener datos desde mysql 
/* * *************************************************** */
$data=NULL;
$conex = new conexionMYSQL();
$conex->conectar();
$sql = "SELECT * FROM v_producto_marca_categoria order by id_producto";
$result = mysql_query($sql);
$num_col = mysql_num_rows($result);
if (($result) && ($num_col > 0)) {
    while ($lista = mysql_fetch_row($result)) {
        $data[] = $lista;        
    }    
} 
mysql_free_result($result);
$conex->desconectar();


/* * *************************************************** */
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);

//$pdf->AddPage();
//$pdf->BasicTable($header, $data);

//$pdf->AddPage();
//Salto de linea para la tabla
//$pdf->Ln(45);

$pdf->FancyTable($header, $data);

$pdf->Output();
?>