<?php
session_start();
require_once 'controlador/actores/C_Proveedor.php';
require_once 'controlador/facturas/C_FacturaCompras.php';
require_once 'vista/pag/FormHorizontal.php';
require_once 'controlador/productos/C_Productos.php';
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang = "es">
        <head>
            <?php require_once 'vista/pag/head.php';
            ?> 
            <link href="extras/css/agrega_ico.css" rel="stylesheet" type="text/css"/>
            
            <link href="extras/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>          
            <script src="extras/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script>
                $(document).ready(function () {
                    $('#tabla1').DataTable();
                    $('#tabla2').DataTable();
                });
            </script>
        </head>

        <body>
            <?php
            require_once 'vista/pag/menu.php';
            ?>

            <div class="container">
                <?php
                $ahora = time();
                if ($ahora < $_SESSION['s_fin']) {
                    if ($_SESSION['s_id_rol'] == "1" or $_SESSION['s_id_rol'] == "2") {
                        
                        $nObj = new C_FacturaCompras();
                        $fact = $nObj->listaFacturaCompras();
                        $factura = '20030050';
                        $vect = array('Num Fact', 'Fecha Compra','Estado',  'Proveedor', 'Empleado');
                        if ($fact != NULL) {
                            $numElementos = count($vect);
                            if (!empty($_GET['dato']) and isset($_GET['dato'])) {
                                
                            }
                            ?> 
                            <table id="tabla2" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <?php
                                        for ($i = 0; $i < $numElementos; $i++) {
                                            echo '<td ><strong>' . $vect[$i] . '</strong></td>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($fact as $datos) {
                                    echo '<tr>';
                                    for ($i = 0; $i < $numElementos+2; $i++) {
                                        if ($i != 3 and $i != 5) {
                                            if ($i == 2)
                                                echo '<td> ' . estado($datos[0], $datos[1]) . ' </td>';
                                            else
                                                echo '<td> ' . $datos[$i] . ' </td>';
                                        }
                                    }
                                    echo '</tr>';
                                }
                                ?> 
                            </table>                    
                            <?php
                        }
         
                        if (isset($_POST['actualizar'])) {
                            if ($nObj->actualizar_factura_detalle_stok()) {
                                mensaje_act_ok();
                            } else {
                                mensaje_act_error();
                            }
                        }
           
                        $resultado = $nObj->listar_detalle_compras_stok($factura);
                        $vect1 = array('ID-TRAN', 'CANT', 'STOK', 'COD BARRAS', 'DESC', 'V. COM', 'V.VENTAS', 'UTILIDAD', '');
                        $vect2 = array('3%', '5%', '5%', '10%', '30%', '10%', '10%', '10%', '10%');
                        ?>
                        <div class="table-responsive">
                            <table id="tabla1" class="display" cellspacing="0" width="100%">
                                <thead>                   
                                    <tr class="success" align="center">
                                        <?php
                                        for ($i = 0; $i < count($vect1); $i++) {
                                            echo '<td width=' . $vect2[$i] . '><strong>' . $vect1[$i] . '</strong></td>';
                                        }
                                        ?>                          
                                    </tr>
                                </thead>
                                <?php
                                if ($resultado != NULL) {
                                    foreach ($resultado as $fila) {
                                        ?> 
                                        <tr>
                                            <td> <?php echo $fila[0] ?></td> 
                                            <td><?php echo $fila[1] ?></td>                                    
                                            <td><?php echo $fila[2] ?></td>
                                            <td><?php echo $fila[3] ?></td>
                                            <td><?php echo $fila[4] ?></td>
                                            <td><?php echo '$' . round(($fila[1] * $fila[5]), 2) ?></td>
                                            <td><?php echo '$' . round(($fila[1] * $fila[6]), 2) ?></td>  
                                            <td><?php echo '$' . round((($fila[1] * $fila[6]) - ($fila[1] * $fila[5])), 2) ?></td>  

                                            <td>
                                                <a href="#actualizar<?php echo $fila[0] ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="ACTUALIZAR">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <a href="#eliminar<?php echo $fila[0] ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="ELIMINAR" >
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="eliminar<?php echo $fila[0] ?>" 
                                             role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form name="form2" method="post" enctype="multipart/form-data" >
                                                        <input type="hidden" name="id_transaccion" value="<?php echo $fila[0] ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3 class="modal-title">ELIMINAR REGISTRO</h3>
                                                        </div> 
                                                        <div class="modal-body alert-danger">
                                                            <div class="row">
                                                                <div class="alert-danger" align="center">ESTA SEGURO QUE DESEA ELIMINAR EL REGISTRO</div>
                                                                <div align="center"><?php echo $fila[0] . ' ' . $fila[2] ?></div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <center><button type="submit" class="btn btn-default" name="cancelar" ><strong><span class="glyphicon glyphicon-stop"></span> CANCELAR</strong></button></center>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <center><button type="submit" class="btn btn-danger" name="eliminar" ><strong><span class="glyphicon glyphicon-trash"></span> ELIMINAR EQUIPO</strong></button></center>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="actualizar<?php echo $fila[0] ?>" 
                                             role="dialog" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form name="formAct" method="post" enctype="multipart/form-data" >
                                                        <input type="hidden" name="id_act" value="<?php echo $fila[0] ?>">
                                                        <input type="hidden" name="factura" value="<?php echo $factura ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3 class="modal-title">ACTUALIZAR REGISTRO</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <strong>COD BARRAS</strong><br>
                                                                    <input type="text" name="codigobarras" class="form-control" value="<?php echo $fila[3]; ?>" disabled><br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>PRODUCTO</strong><br>
                                                                    <input type="text" name="producto" class="form-control" value="<?php echo $fila[4]; ?>" disabled><br>
                                                                </div>


                                                                <div class="col-md-6" >
                                                                    <strong>CANTIDAD</strong><br>
                                                                    <input type="text" name="cantidad_act" class="form-control" value="<?php echo $fila[1]; ?>" disabled><br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>STOK</strong>
                                                                    <input type="text" name="stok_act" class="form-control" value="<?php echo $fila[2]; ?>">                                                                
                                                                </div >
                                                                <div class="col-md-12">
                                                                    <center><button type="submit" class="btn btn-success" name="actualizar"><strong><i class="icon-ok"></i>ACTUALIZAR</strong></button></center>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </table>   
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <?php $total = $nObj->total_factura_compras($factura);                ?>
                                        
                                        <tr><td class="info" width="11%"><strong>DESCUENTO :</strong>$ 0.00</td> 
                                            <td class="success" width="9%"><strong>SUBTOTAL :</strong> $<?php echo round(($total['total'] / 1.12), 2); ?></td>
                                            <td class="danger" width="9%"><strong>TARIFA 0% :</strong> $ 0.00</td>
                                            <td class="info" width="10%"><strong>TARIFA 14% :</strong> $<?php echo round(($total['total'] / 1.12), 2); ?></td>
                                            <td class="danger" width="5%"><strong>IVA :</strong> $<?php echo round($total['total'], 2) - round(($total['total'] / 1.12), 2) ?></td>
                                            <td class="info" width="8%"><strong>TOTAL :</strong> $<?php echo round($total['total'], 2); ?></td>
                                        </tr>                       
                                    </table>  

                                </div>
                                <?php
                            }
                            ?>

                        </div>

                        <?php
                    } else {
                        echo '  <div class="alert alert-info">
                                    <strong>INFORMACION!</strong> Espacio no Habilitado para Este usuario.
                                </div>';
                    }
                } else {
                    session_destroy();
                }
                ?>
            </div>
        </body>
    </html>
    <?php
}
?>
