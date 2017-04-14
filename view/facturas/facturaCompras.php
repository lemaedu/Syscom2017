<?php
session_start();
require_once 'controlador/actores/C_Proveedor.php';
require_once 'controlador/facturas/C_FacturaCompras.php';
require_once 'vista/pag/FormHorizontal.php';
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php require_once 'vista/pag/head.php'; ?>  

            <link href="extras/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>          
            <script src="extras/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script>
                $(document).ready(function () {
                    $('#tabla').DataTable();
                    $('#tabla2').DataTable();
                });
            </script>
        </head>
        <body>
            <?php require_once 'vista/pag/menu.php'; ?>
            <div class="container">                
                <div class="col-xs-12">
                    <?php
                    $factura = NULL;
                    $nObj = new C_Proveedor();
                    $nObj2 = new C_FacturaCompras();

                    if (isset($_POST['btnFact']) and ! (empty($_POST['btnFact']))) {
                        if ($nObj2->crear_factura_compras()) {
                            $_SESSION['proveedor'] = $_POST['btnFact'];
                        };
                    }

                    if (isset($_POST['btn_cerrar_factura'])) {                        
                        if ($nObj->cerrarFacturaActivada()) {
                            
                        };
                    }
                    $result = $nObj->FacturaActivada();
                    if ($result != NULL) {
                        //Muestra factura Activa
                        foreach ($result as $fila) {
                            $factura = $fila[0];
                            ?>
                            <div class="col-xs-12">
                                <!------- MUESTRA FACTURA ABIERTA---------->
                                <div class=" panel panel-primary">                                                                
                                    <div class="panel-heading"> <h5><?php
                                            echo '<strong>PROVEEDOR:</strong> ' . $fila[4] . '  //  <strong>RUC:</strong> ' . $fila[3]
                                            . ' // <strong>FACTURA : </strong>' . $fila[0] . ' // <strong>FECHA DE COMPRA : </strong>' . $fila[2]
                                            ?></h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-8">
                                            FACTURA DE COMPRA ABIERTA                                            
                                            <a href="#cerrar_factura<?php echo $fila[0] ?>" role="button" class="btn btn-mini btn-default" data-toggle="modal" title="Cerrar Factura"> CERRAR FACTURA
                                                <span class="glyphicon glyphicon-log-out"></span>
                                            </a>    
                                        </div>
                                        <div class="col-md-4">                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---- MODAL PARA CERRAR FACTURA------------------>
                            <div class="modal fade" id="cerrar_factura<?php echo $fila[0] ?>" 
                                 role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form name="form2" method="post" enctype="multipart/form-data" action="">
                                            <input type="hidden" name="id_factura_cerrar" value="<?php echo $fila[0] ?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h3 class="modal-title">CERRAR FACTURA</h3>
                                            </div> 
                                            <div class="modal-body alert-info">
                                                <div class="row">
                                                    <div class="alert-info" align="center">¿ESTA SEGURO QUE DESEA CERRAR LA FACTURA No: <?php echo $fila[0] ?> ?</div>
                                                    <div align="center">Si Cierra la factura no podrá agregar más registros</div><br>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <center><button type="submit" class="btn btn-default" name="cancelar" ><strong> CANCELAR</strong></button></center>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <center><button type="submit" class="btn btn-success" name="btn_cerrar_factura" ><strong>CERRAR FACTURA</strong></button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        $nObj = new C_FacturaCompras ();
                        if (isset($_POST['btnRegistrar'])) {
                            if ($nObj->crear_factura_detalle($factura)) {
                                mensaje_add_ok();
                            } else {
                                mensaje_add_error();
                            }
                        }
                        if (isset($_POST['actualizar'])) {
                            if ($nObj->actualizar_factura_detalle()) {
                                mensaje_act_ok();
                            } else {
                                mensaje_act_error();
                            }
                        }
                        if (isset($_POST['eliminar'])) {
                            if ($nObj->eliminar_factura_detalle($factura)) {
                                mensaje_add_ok();
                            } else {
                                mensaje_add_error();
                            }
                        }
                        if (!empty($_POST['buscar_producto'])) {
                            require_once 'controlador/productos/C_Productos.php';
                            $nObj1 = new C_Productos();
                            $resultado = $nObj1->buscar_productos_pf();
                            ?>

                            <table id="tabla" class="display" cellspacing="0" width="100%">
                                <thead>                        
                                    <tr class="success" align="center">
                                        <td width="5%"><strong>ID</strong></td>
                                        <td width="15%"><strong>Cod BARRAS</strong></td>                            
                                        <td width="30%"><strong>PRODUCTOS</strong></td>
                                        <td width="10%"><strong>DESCRIPCION</strong></td>
                                        <td width="10%"><strong>IMAGEN</strong></td>
                                        <td width="10%"><strong></strong></td>
                                    </tr>
                                </thead>
                                <?php
                                if ($resultado != NULL) {
                                    foreach ($resultado as $fila) {
                                        ?>                          
                                        <tr>
                                            <td><?php echo $fila[0] ?></td>
                                            <td><?php echo $fila[1] ?></td>                                    
                                            <td><?php echo $fila[2] ?></td>
                                            <td><?php echo $fila[3] ?></td>
                                            <td><?php echo $fila[4] ?></td>                                            
                                            <td>

                                                <a href="#venta<?php echo $fila[0] ?>" role="button" class="btn btn-mini btn-default" data-toggle="modal" title="venta">
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                </a>                                           
                                            </td>
                                        </tr>
                                        <!--  FORMULARIO VENTA -->
                                        <div class="modal fade" id="venta<?php echo $fila[0] ?>" 
                                             role="dialog" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form name="form2" method="post" enctype="multipart/form-data" >
                                                        <input type="hidden" name="id_producto" value="<?php echo $fila[0] ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3 class="modal-title">REGISTRO</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">

                                                                <div class="col-md-2">  
                                                                    <strong>CANTIDAD</strong><br>
                                                                    <input type="text" name="cantidad" class="form-control" placeholder="150"><br>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <strong>PRECIO DE COMPRA</strong><br>
                                                                    <input type="text" name="valor_compra" class="form-control" value="" placeholder="10.25"><br>                                                                
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <strong>DESCUENTO</strong><br>
                                                                        <select class="form-control" name="descuento">                                                                        
                                                                            <?php
                                                                            for ($i = 0; $i < 25; $i++) {
                                                                                ?>                                                    
                                                                                <option value="<?php echo $i / 100 ?>"><?php echo $i ?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>                                     
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2"> 
                                                                    <strong></strong><br>
                                                                    <center><button type="submit" class="btn btn-success" name="btnRegistrar"><strong>Registrar</strong></button></center>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php
                        };
                
                        ?>


                        <div  class="col-xs-12">
                            <form accept-charset = "utf-8" method = "POST" name = "form1" action = "">
                                <strong>PRODUCTOS</strong>
                                <span class = "glyphicon glyphicon-ok"></span>
                                <input name = "buscar_producto" id = "buscar_producto" type = "text" placeholder = "Buscar producto" autocomplete = "off" class = "form-control"><br>
                            </form> 
                            <!--------------------------------------------------------------------------->
                        </div>


                        <div  class="col-xs-12">
                            <?php
                            require_once 'controlador/productos/C_Productos.php';
                            $nObj = new C_FacturaCompras();
                            $result = $nObj->listar_detalle_compras($factura);
                            ?>
                            <div class="table-responsive">
                                <table id="tabla2" class="display" cellspacing="0" width="100%">
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
                                                <td><?php echo '$' . $fila[5] ?></td>
                                                <td><?php echo $fila[7] * 100 ?>%</td>
                                                <td><?php echo '$' . round(($fila[1] * $fila[6]), 2) ?></td>                                            
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
                                                        <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                            <input type="hidden" name="id_transaccion" value="<?php echo $fila[0] ?>">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h3 class="modal-title">ELIMINAR REGISTRO</h3>
                                                            </div> 
                                                            <div class="modal-body alert-danger">
                                                                <div class="row">
                                                                    <div class="alert-danger" align="center">ESTA SEGURO QUE DESEA ELIMINAR EL REGISTRO</div>
                                                                    <div align="center"><?php echo $fila[0] . ' ' . $fila[2] ?></div><br>

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
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h3 class="modal-title">ACTUALIZAR REGISTRO</h3>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">                                            
                                                                        <strong>CANTIDAD</strong><br>
                                                                        <input type="text" name="cantidad_act" class="form-control" value="<?php echo $fila[1]; ?>"><br>
                                                                        <strong>P. UNITARIO</strong>
                                                                        <input type="text" name="p_unitario_act" class="form-control" value="<?php echo $fila[5]; ?>"><br>                                                                
                                                                        <div class="form-group">
                                                                            <strong>DESCUENTO</strong><br>
                                                                            <select class="form-control" name="descuento_act">  
                                                                                <option value="<?php echo $fila[7] ?>"><?php echo $fila[7] * 100; ?>%</option>
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
                                                                    <div class="col-md-8">
                                                                        <strong>VALOR VENTA</strong><br>
                                                                        <input type="text" name="valor_venta" class="form-control" value="<?php echo $fila[8]; ?>" ><br>                                                              

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
                                        ?>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover">
                                                <?php $total = $nObj->total_factura_compras($factura); ?>
                                                <tr><td class="info" width="11%"><strong>DESCUENTO :</strong>$ 0.00</td> 
                                                    <td class="success" width="9%"><strong>SUBTOTAL :</strong> $<?php echo round(($total['total'] / 1.12), 2); ?></td>
                                                    <td class="danger" width="9%"><strong>TARIFA 0% :</strong> $ 0.00</td>
                                                    <td class="info" width="10%"><strong>TARIFA 14% :</strong> $<?php echo round(($total['total'] / 1.12), 2); ?></td>
                                                    <td class="danger" width="5%"><strong>IVA :</strong> $<?php echo round($total['total'], 2) - round(($total['total'] / 1.12), 2) ?></td>
                                                    <td class="info" width="8%"><strong>TOTAL :</strong> $<?php echo round($total['total'], 2); ?></td></tr>                       
                                            </table>                        
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>



                        <?php
                    } else {
                        if (!isset($_POST['btnFact'])) {
                            echo '<form class="navbar-form navbar-left"  method="POST">
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                            <input id="buscar" type="text" class="form-control" name="buscar" value="" placeholder="Buscar Proveedor" required>                                        
                                        </div>                                                                     
                                    </form>';
                        }
                    }
                    //---------------busca, lista proveedor--------------------------//
                    if (isset($_POST["buscar"]) and ! empty($_POST["buscar"])) {
                        ?>
                        <table class="table table-hover">                        
                            <tr>
                                <td width="15%">CI/RUC</td>
                                <td width="20%">PROVEEDOR</td>
                                <td width="20%">TELEFONO</td>
                                <td width="20%">DIRECCION</td>
                                <td width="15%"></td>
                            </tr>                        
                            <?php
                            $nObj = new C_Proveedor();
                            $result = $nObj->buscar($_POST["buscar"]);
                            if ($result != NULL) {
                                foreach ($result as $fila) {
                                    ?>
                                    <tr>
                                        <td><i class="icon-book"></i> <?php echo $fila[0]; ?></td>
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

                <div class="col-xs-12">
                    <?php
                    //------------  CREA FORMULARIO PARA INGRESAR FECHA DE COMPRA Y NUMERO DE FACTURA---------------------//
                    if (isset($_POST['btnOk'])) {
                        $nObj = new C_Proveedor();
                        $result = $nObj->buscar($_POST['btnOk']);
                        if ($result != NULL) {
                            foreach ($result as $fila) {
                                ?>
                                <div class=" panel panel-primary">
                                    <div class="panel-heading"> <h4><?php echo '<strong>PROVEEDOR:</strong> ' . $fila[1] . ' <strong>RUC:</strong> ' . $fila[0]; ?></h4></div>
                                    <div class="panel-body">
                                        <form method="POST">
                                            <div class="col-md-6">
                                                <strong>NUMERO DE FACTURA</strong><br>
                                                <input  class="form-control" type="text" name="factura" autocomplete="off" required>                                                           

                                            </div>
                                            <div class="col-md-6">                                                                                        
                                                <?php txt_calendario4("fecha de compra", "") ?>
                                                <br>
                                                <button type="submit" class="btn btn-success" name="btnFact" id="btnFacturaCompa" value="<?php echo $fila[0] ?>">REGISTRAR</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <!--   HASTA AQUI EL PANEL DE USUARIO -->
                <?php ?> 


            </div>
        </body>
    </html>
    <?php
}
?>
