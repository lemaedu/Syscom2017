<?php
session_start();
require_once 'controller/actores/C_Cliente.php';
require_once 'controller/facturas/C_FacturaVentas.php';
require_once 'view/page/FormHorizontal.php';
require_once 'view/page/pagElementos.php';
require_once 'controller/productos/C_Producto.php';

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {

    $dia = date("j");
    $mes = date("m");
    $anio = date("Y");
    $fechaActual = $anio . '-' . $mes . '-' . $dia;
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
                    $('#tabla1').DataTable();
                });

            </script>
            <script src="extras/js/funciones_sys.js" type="text/javascript"></script>
        </head>
        <body>
            <?php require_once 'view/page/menu.php'; ?>
            <div class="container">
                <div class="row"> 
                    <?php
                    $nObj = new C_FacturaVentas();
                    $totalNeto = 0;

                    $total = $nObj->total_factura_ventas();
                    $descuento = $nObj->descuento_factura_ventas();
                    $totalNeto = round($total['total'], 2);
                    //------------  CREA FORMULARIO PARA INGRESAR FECHA DE COMPRA Y NUMERO DE FACTURA---------------------//
                    if (isset($_POST['btnOk']) and ! empty($_POST['btnOk'])) {
                        $result = $nObj->crear_factura_venta($fechaActual);
                    }
                    ?> 


                    <div class="col-xs-12">
                        <?php
                        $factura = NULL;
                        //*-----------  CIERRA LA VENTA--------------/
                        if (isset($_POST['btn_cerrar_factura'])) {
                            if ($nObj->cerrarFacturaActivada()) {
                                
                            };
                        }
                        /* ------ MUESTRA FACTURAS ABIERTAS ---------- */
                        $result = $nObj->FacturaActivada();
                        if ($result != NULL) {
                            foreach ($result as $fila) {
                                $factura = $fila[7];
                                ?>                                
                                <!------- MUESTRA FACTURA ABIERTA---------->
                                <div class=" panel panel-info"> 
                                    <div class="panel-heading">FACTURA N0. <?php echo $fila[7] ?> 

                                        <a href="#cerrar<?php echo $fila[7] ?>" align="right" role="button" class="btn btn-mini btn-danger" data-toggle="modal"> Cerrar
                                            <span class="glyphicon glyphicon-log-out"></span>
                                        </a> 

                                        <a href="#pendiente<?php echo $fila[7] ?>" align="right" role="button" class="btn btn-mini btn-warning" data-toggle="modal"> Pendiente
                                            <span class="glyphicon glyphicon-transfer"></span>
                                        </a> 

                                        <a href="#cobrar<?php echo $fila[7] ?>" align="right" role="button" class="btn btn-mini btn-success" data-toggle="modal"> Cobrar
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </a> 


                                        <a href="index.php?page=20" align="right" role="button" class="btn btn-mini btn-primary" data-toggle="modal" > Imprimir
                                            <span class="glyphicon glyphicon-paste"></span>
                                        </a> 


                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-7">
                                            <strong>CLIENTE:</strong> <?php echo $fila[0]; ?>                                            
                                            <strong>RUC/CI:</strong> <?php echo $fila[1]; ?>                                                                                       
                                        </div>

                                        <div class="col-md-5">
                                            <strong>FECHA</strong>: <?php echo $fila[5]; ?>                                                                                       

                                        </div>
                                    </div>
                                </div>
                                <!---- VENTA PARA CERRAR FACTURA------------------>                                                                
                                <?php
                                div_cerrar($fila[7]);
                                div_pendiente($fila[7]);
                                div_cobrar($fila[7], $totalNeto);
                            }
                            ?>
                            <!--  SECCION BUSQUEDA DE PRODUCTOS-->
                            <div class = "col-xs-12">

                                <div class = "row">
                                    <div class = "col-md-6">
                                        <form accept-charset = "utf-8" method = "POST" name = "form1" action = "">
                                            <strong>PRODUCTOS AUTOMATICO</strong>
                                            <span class = "glyphicon glyphicon-barcode"></span>
                                            <input name = "codigo_barras" id = "codigo_barras" type = "text" placeholder = "Codigo de barras" autocomplete = "off" class = "form-control"><br>
                                        </form>
                                    </div>
                                    <div class = "col-md-6">
                                        <form accept-charset = "utf-8" method = "POST" name = "form1" action = "">
                                            <strong>PRODUCTOS MANUALMENTE</strong>
                                            <input name = "buscar_producto" id = "buscar_producto" type = "text" placeholder = "Buscar producto"
                                                   autocomplete = "off" class = "form-control" >
                                        </form>
                                    </div>
                                </div>


                                <!--------------------------------------------------------------------------->
                                <?php
                                if (isset($_POST['btn_agregar_factura'])) {
                                    if ($nObj->agregar_producto_factura($factura)) {
                                        mensaje_add_ok();
                                    } else {
                                        mensaje_add_error();
                                    }
                                }
                                if (isset($_POST['actualizar'])) {
                                    if ($nObj->actualizar_factura_detalle_ventas($factura)) {
                                        mensaje_act_ok();
                                    } else {
                                        mensaje_act_error();
                                    }
                                }
                                if (isset($_POST['eliminar'])) {
                                    if ($nObj->eliminar_detalle_factura_ventas($factura)) {
                                        mensaje_add_ok();
                                    } else {
                                        mensaje_add_error();
                                    }
                                }
                                if (!empty($_POST['codigo_barras'])) {
                                    $nObj1 = new C_Productos();
                                    $result = $nObj1->buscar_productos_disponibles_por_codBarr();

                                    $id_prod = 0;
                                    $cant = 0;
                                    $valorVenta = 0;
                                    $id_comp = 0;

                                    if ($result != NULL) {
                                        foreach ($result as $fila) {
                                            $id_prod = $fila[7];
                                            $cant = 1;
                                            $valorVenta = $fila[3];
                                            $id_comp = $fila[0];
                                        }
                                    }

                                    if ($nObj->agregar_producto_factura_codBarr($factura, $id_prod, $cant, $valorVenta, $id_comp)) {
                                        mensaje_add_ok();
                                    } else {
                                        mensaje_add_error();
                                    }
                                }

                                if (!empty($_POST['buscar_producto'])) {


                                    $nObj = new C_Producto();
                                    $result = $nObj->buscar_productos_disponibles();
                                    ?>
                                    <!--MUSTRA TABLA CON RESULTADOS DE BUSQUEDA-->
                                    <table id="tabla1" class="display" cellspacing="0" width="100%">
                                        <thead> 
                                            <tr class="success" align="center">
                                                <td width="40%"><strong>PRODUCTO</strong></td>                                                
                                                <td width="10%"><strong>P. UNIT</strong></td>
                                                <td width="10%"><strong>DISPONIBLE</strong></td>                                                                                    
                                                <td width="10%"><strong></strong></td>
                                            </tr>
                                        </thead>

                                        <?php
                                        if ($result != NULL) {
                                            foreach ($result as $fila) {
                                                ?>                          
                                                <tr>
                                                    <td> <?php echo $fila[1] ?></td>                                                        
                                                    <td><?php echo $fila[3] ?></td>
                                                    <td><?php echo $fila[4] ?></td>                                                        
                                                    <td>                                                        
                                                        <form method="POST" id="">
                                                            <input type="hidden" name="id_producto" value="<?php echo $fila[7] ?>">
                                                            <input type="hidden" name="cantidad" value="1">
                                                            <input type="hidden" name="valor_venta" value="<?php echo $fila[3] ?>">
                                                            <input type="hidden" name="id_compra" value="<?php echo $fila[0] ?>">
                                                            <button type="submit" class="btn btn-success" name="btn_agregar_factura" id="btn_agregar_factura" value="<?php echo $fila[0] ?>">OK</button>
                                                        </form>
                                                    </td>
                                                </tr>                       

                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>

                                    <?php
                                };
                                ?> 
                            </div>
                            
                            <div id="resultadoBusqueda" name="resultadoBusqueda">
                            </div>

                            <?php
                        } else {
                            if (!isset($_POST['btnFact'])) {
//                                FORMULARIO PARA BUSQUEDA DE CLIENTES
                                echo '
                                    <form class="navbar-form navbar-left"  method="POST">
                                        <div style="margin-bottom: 15px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                            <input id="buscar" type="text" class="form-control" name="buscar" value="" placeholder="Buscar Cliente...." required>                                        
                                        </div>                                                                     
                                    </form>';
                            }
                        }
                        //---------------MUESTRA LISTA CLIENTES ENCONTRADOS--------------------------//
                        if (isset($_POST["buscar"]) and ! empty($_POST["buscar"])) {
                            ?>
                            <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td width="15%">CI/RUC</td>
                                        <td width="20%">CLIENTE</td>
                                        <td width="20%">TELEFONO</td>
                                        <td width="20%">DIRECCION</td>
                                        <td width="15%"></td>
                                    </tr>
                                </thead>
                                <?php
                                $nObj = new C_Cliente();
                                $result = $nObj->buscar_cliente();
                                if ($result != NULL) {
                                    foreach ($result as $fila) {
                                        ?>
                                        <tr>
                                            <td><?php echo $fila[0]; ?></td>
                                            <td><?php echo $fila[1]; ?></td>
                                            <td><?php echo $fila[2]; ?></td>
                                            <td><?php echo $fila[3]; ?></td>                                                                         
                                            <td> 
                                                <form method="POST">
                                                    <button type="submit" class="btn btn-success" name="btnOk" id="btnOk" value="<?php echo $fila[0] ?>">OK</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                    </div>                                       
                    <!--   MUESTRA DETALLE DE FACTURAS -->
                    <div  class="col-xs-12">
                        <?php
                        $nObj = new C_FacturaVentas();
                        $result = $nObj->detalle_factura_ventas($factura);
                        if ($result != NULL) {
                            ?>
                            <div class="table-responsive">
                                <table id="tabla" class="display" cellspacing="0" width="100%">
                                    <thead>                    
                                        <tr class="success" align="center">
                                            <td width="5%"><strong>ID-TRAN</strong></td>
                                            <td width="8%"><strong>CANT</strong></td>
                                            <td width="30%"><strong>DESCRIPCION</strong></td>                            
                                            <td width="8%"><strong>P. UNIT</strong></td>
                                            <td width="9%"><strong>DESC.</strong></td>
                                            <td width="10%"><strong>P. Total</strong></td>                    
                                            <td width="10%"><strong></strong></td>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($result != NULL) {
                                        foreach ($result as $fila) {
                                            ?> 
                                            <tr>
                                                <td> <?php echo $fila[0] ?></td> 
                                                <td><?php echo $fila[1] ?></td>                                    
                                                <td><?php echo $fila[2] ?></td>
                                                <td><?php echo '$' . round(($fila[3] - $fila[3] * $fila[4]), 4) ?></td>
                                                <td><?php echo $fila[4] * 100 . '%'; ?></td>
                                                <td><?php echo '$' . round((round(($fila[1] * $fila[3]), 2) - round(($fila[1] * $fila[3]), 2) * $fila[4]), 2) ?></td>                                            
                                                <td>
                                                    <a href="#actualizar<?php echo $fila[0] ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="ACTUALIZAR">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </a>
                                                    <a href="#eliminar<?php echo $fila[0] ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="ELIMINAR" >
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php formulario_eliminar($fila[0], $fila[2]) ?>

                                            <div class="modal fade" id="actualizar<?php echo $fila[0] ?>" 
                                                 role="dialog" >
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form name="formAct" method="post" enctype="multipart/form-data" >
                                                            <input type="hidden" name="id_act" value="<?php echo $fila[0] ?>">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h3 class="modal-title">ACTUALIZAR REGISTRO</h3>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-2">                                            
                                                                        <strong>CANTIDAD</strong><br>
                                                                        <input type="text" name="cantidad_act" class="form-control" value="<?php echo $fila[1]; ?>"><br>                                                                                                                                   

                                                                    </div >
                                                                    <div class="col-md-3">
                                                                        <strong>P. UNITARIO</strong>
                                                                        <input type="text" name="p_unitario_act" class="form-control" value="<?php echo $fila[3]; ?>"><br> 
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <strong>DESCUENTO</strong><br>
                                                                            <select class="form-control" name="descuento_act">                                                                            
                                                                                <option value="<?php echo $fila[4]; ?>"><?php echo $fila[4] * 100 . '%' ?></option>
                                                                                <?php
                                                                                for ($i = 0; $i < 25; $i++) {
                                                                                    ?>                                                    
                                                                                    <option value="<?php echo $i / 100 ?>"><?php echo $i . '%' ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>                                     
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-5">                                                                                                                     

                                                                        <strong>PRODUCTO</strong><br>
                                                                        <input type="text" name="precio_venta" class="form-control" value="<?php echo $fila[2]; ?>"><br>
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
                                    }
                                    ?>
                                </table>
                            </div> 
                            <?php ?>
                            <!--Muestra Operaciones de totales--> 
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <?php
                                        $total = $nObj->total_factura_ventas();
                                        $descuento = $nObj->descuento_factura_ventas();
                                        ?>
                                        <tr><td class="info" width="11%"><strong>DESCUENTO :</strong>$ <?php echo round($descuento['descuento'] - $total['total'], 2) ?></td> 
                                            <td class="success" width="9%"><strong>SUBTOTAL :</strong> $<?php echo round(($total['total'] / 1.14), 2); ?></td>
                                            <td class="danger" width="9%"><strong>TARIFA 0% :</strong> $ 0.00</td>
                                            <td class="info" width="10%"><strong>TARIFA 14% :</strong> $<?php echo round(($total['total'] / 1.14), 2); ?></td>
                                            <td class="danger" width="5%"><strong>IVA :</strong> $<?php echo round($total['total'], 2) - round(($total['total'] / 1.14), 2) ?></td>
                                            <td class="info" width="8%"><strong>TOTAL :</strong> $<?php echo round($total['total'], 2); ?> </td></tr>                       
                                    </table>  
                                </div>
                            </div>
                            <?php
                        }
                        ?> 
                    </div>

                </div>

            </div>

        </body>
    </html>
    <?php
}
?>
