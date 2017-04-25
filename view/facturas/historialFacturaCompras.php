<?php
session_start();
require_once ('controller/actores/C_Proveedor.php');
include_once('controller/productos/C_Producto.php');
include_once('controller/facturas/C_FacturaCompras.php');
require_once ('view/page/FormHorizontal.php');

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {

    $fechaactual = getdate();
    $hoy = "$fechaactual[mday]-$fechaactual[mon]-$fechaactual[year]";  

    $nObj = new C_FacturaCompras();
    if (isset($_POST['btnEstado']) and ! empty($_POST['btnEstado'])) {
        $estado = $nObj->cambiarestadoFactura();
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php require_once 'view/page/head.php'; ?> 
            
            <link href="resourse/dataTable/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
            <script src="resourse/dataTable/jquery.dataTables.min.js" type="text/javascript"></script>
            <script>
                $(document).ready(function () {
                    $('#tabla').DataTable();
                });
            </script>
        </head>

        <body>
            <?php require_once 'view/page/menu.php'; ?>
            <div class="container">
                <div class="row">                    
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="col-md-4">
                                    <a href="#nuevo" class="btn btn-primary" role="button" data-toggle="modal">
                                        <span class="glyphicon glyphicon-file"></span> Nuevo
                                    </a>
                                    <div class="btn-group">
                                        <button class="btn btn-info" data-toggle="dropdown">
                                            <span class="glyphicon glyphicon-list"></span> <strong>Consultar por</strong> <span class="caret"></span>
                                        </button>

                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <a href="#" role="button" class="btn btn-toolbar" data-toggle="modal" title="Imprimir">
                                        <span class="glyphicon glyphicon-print"></span>
                                    </a> 
                                    <a href="view/Reportes/RepProductos.php" target="_blank" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <form accept-charset="utf-8" method="POST" name="form1" action="">
                                        <div class="input-group">                                                                                        
                                            <?php
                                            txt_calendario3('Fecha', $hoy);
                                            ?>

                                        </div>
                                    </form> 
                                </div>

                            </div>                      
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table id="tabla" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="success" align="center">
                                        <!--imprime cabecera de la tabla--> 
                                        <?php
                                        $array = array("N0. FAC", "FECHA", "ESTADO FACT.", "PROVEDOR", "EMPLEADO", "TOT. COMPRAS", "");
                                        for ($i = 0; $i < count($array); $i++) {
                                            echo '<td ><strong>' . $array[$i] . '</strong></td>';
                                        }
                                        ?>                                                                               
                                    </tr>
                                </thead>
                                <?php
                                if (empty($_POST['buscar_producto'])) {
                                    $resultados = $nObj->listaFacturaCompras();
                                } else {
                                    $resultados = $nObj->buscar();
                                }

                                if ($resultados != NULL) {
                                    foreach ($resultados as $fila) {
                                        ?>
                                        <!---------------------AQUI SE IMPRIME TODAS LAS COLUMNAS DE LA TABLA----------------->

                                        <tr>
                                            <td><?php echo $fila[0] ?></td>
                                            <td><?php echo $fila[1] ?></td>
                                            <td><?php echo estado1($fila[0], $fila[2]) ?></td>
                                            <td><?php echo $fila[4] ?></td>
                                            <td><?php echo $fila[6] ?></td>
                                            <td><?php echo round($fila[7], 2) ?></td>
                                            <?php
                                            $id = $fila[0];
                                            boton_pdf($id)
                                            ?>
                                        </tr>

                                        <!-----------------------------------FORMULARIO ACTUALIZAR---------------------------------->
                                        <?php
                                    }
                                } else {
                                    echo '<div class="alert alert-info" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>NO HAY REGISTROS POR MOSTRAR</strong>
					</div>';
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </body>
    </html>
    <?php
}
?>
