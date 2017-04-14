<?php
session_start();
include_once('controller/actores/C_Cliente.php');
require_once ('view/page/FormHorizontal.php');
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
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



                        <div class="col-md-4">
                            <a href="#nuevo" class="btn btn-primary" role="button" data-toggle="modal">
                                <span class="glyphicon glyphicon-file"></span> Nuevo
                            </a>
                            <a href="#" role="button" class="btn btn-toolbar" data-toggle="modal" title="Imprimir">
                                <span class="glyphicon glyphicon-print"></span>
                            </a> 
                            <a href="#" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                            <a href="#" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                            </a>
                         
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-4">
                            <form accept-charset="utf-8" method="POST" name="form1" action="">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input id="buscar" type="text" class="form-control" name="buscar_producto" value="" placeholder="Buscar" required>                                        
                                </div>
                            </form> 
                        </div>



                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php
                            if (isset($_POST['crear'])) {
                                $nCliente = new C_Cliente ();
                                if ($nCliente->crear()) {
                                    echo '	<div class="alert alert-info" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong> Equipo Registrado con Exito en la Base de Datos</strong>
					</div>';
                                } else {
                                    echo '	<div class="alert alert-danger" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>Error en Registro</strong>
					</div>';
                                }
                            }
                            if (isset($_POST['actualizar'])) {
                                $nCliente = new C_Cliente ();
                                if ($nCliente->actualizar()) {
                                    echo '	<div class="alert alert-info" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>ACTUALIZADO CORRECTAMENTE</strong>
					</div>';
                                } else {
                                    echo '	<div class="alert alert-danger" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>ERROR EN ACTUALIZAR</strong>
					</div>';
                                }
                            }
                            if (isset($_POST['eliminar'])) {
                                $nCliente = new C_Cliente ();
                                if ($nCliente->eliminar()) {
//                                }
                                    echo '	<div class="alert alert-info" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>ELIMINADO DE LA BASE DE DATOS</strong>
					</div>';
                                } else {
                                    echo '	<div class="alert alert-danger" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>ERROR EN ACTUALIZAR</strong>
					</div>';
                                }
                            }
//                        
                            ?>
                            <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>

                                    <tr>
                                        <td class="active">Id</td>
                                        <td class="active">CEDULA/RUC</td>
                                        <td class="success">NOMBRES</td>
                                        <td class="warning">CORREO</td>
                                        <td class="danger">TELEFONO</td>
                                        <td class="danger">ESTADO</td>
                                        <td >&nbsp;</td>
                                    </tr>
                                </thead>
                                <?php
                                $nCliente = new C_Cliente ();
                                $resultados = $nCliente->listar();
                                if ($resultados != NULL) {
                                    foreach ($resultados as $col) {
                                        ?>
                                        <tr>
                                            <td><?php echo $col['id_cliente'] ?></td>
                                            <td><?php echo $col['cedula'] ?></td>
                                            <td><?php echo $col['nombres'] ?></td>
                                            <td><?php echo $col['correo'] ?></td>
                                            <td><?php echo $col['telefono'] ?></td>                                                                
                                            <td>                                              
                                                <?php echo estado($col['id_cliente'], $col['estado']); ?>

                                            </td>
                                            <!--BOTOTES PARA ELIMINAR Y ACTUALOZAR-->
                                            <?php boton_editar_eliminar($col['id_cliente']) ?>
                                        </tr>


                                        <!-------ELIMINAR REGISTRO------------------------------------------- -->

                                        <div id="eliminar<?php echo $col['id_cliente'] ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                        <input type="hidden" name="id" value="<?php echo $col['id_cliente'] ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">ELIMINAR REGISTRO</h4>
                                                        </div>
                                                        <div class="modal-body alert-danger">

                                                            <div class="alert-danger" align="center">¿ESTA SEGURO QUE DESEA ELIMINAR?</div>
                                                            <div align="center"><?php echo $col['id_cliente'] . ' ' . $col['nombres'] ?></div><br>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <center><button type="submit" class="btn" name="cancelar" ><strong><i class="icon-stop"></i> CANCELAR</strong></button></center>
                                                                </div>
                                                                <div class="col-md-6">

                                                                    <center><button type="submit" class="btn btn-danger" name="eliminar" ><strong><i class="icon-trash"></i> ELIMINAR EQUIPO</strong></button></center>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-------actualizar registro------------------------------------------- -->

                                        <div id="actualizar<?php echo $col['id_cliente'] ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                        <input type="hidden" name="id" value="<?php echo $col['id_cliente'] ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">ACTUALIZAR REGISTRO</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">                                            
                                                                    <strong>CEDULA/RUC</strong><br>
                                                                    <input class="form-control" type="text" name="cedula" autocomplete="off" value="<?php echo $col['cedula']; ?>"><br>
                                                                    <strong>NOMBRE</strong><br>
                                                                    <textarea class="form-control" rows="2" name="nombres" ><?php echo $col['nombres']; ?></textarea><br>
                                                                    <strong>TELEFONO</strong><br>
                                                                    <input class="form-control"  type="text" name="telefono" autocomplete="off" value="<?php echo $col['telefono']; ?>"><br>
                                                                    <strong>CORREO</strong><br>
                                                                    <input class="form-control"  type="text" name="correo" autocomplete="off" value="<?php echo $col['correo']; ?>"><br>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <strong>RIRECCIÓN</strong><br>
                                                                    <textarea class="form-control" rows="2" name="direccion" ><?php echo $col['direccion']; ?></textarea><br>
                                                                    <strong>ESTADO</strong><br>
                                                                    <div class="form-group">                        
                                                                        <select class="form-control" name="estado">
                                                                            <option value="A">ACTIVO</option>
                                                                            <option value="X">DESACTIVO</option>                            
                                                                        </select>
                                                                    </div><br><br>

                                                                    <center><button type="submit" class="btn btn-success" name="actualizar"><strong><i class="icon-ok"></i>ACTUALIZAR</strong></button></center>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div id="nuevo" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form name="form2" method="post" enctype="multipart/form-data" action="">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>CEDULA / RUC</strong><br>
                                        <input class="form-control" type="text" name="cedula" autocomplete="off" required><br>
                                        <strong>NOMBRES</strong><br>
                                        <input class="form-control" type="text" name="nombres" autocomplete="off" required><br>  
                                        <strong>TELEFONO</strong><br>
                                        <input  class="form-control" type="text" name="telefono" autocomplete="off" ><br>
                                        <strong>CORREO</strong><br>
                                        <input class="form-control" type="text" name="correo" autocomplete="off" ><br>
                                    </div>

                                    <div class="col-md-6">
                                        <strong>DIRECCION</strong><br>
                                        <textarea class="form-control" rows="2" name="direccion"></textarea><br>
                                        <strong>ESTADO</strong><br>
                                        <div class="form-group">                        
                                            <select class="form-control" name="estado">
                                                <option value="A">ACTIVO</option>
                                                <option value="X">DESACTIVO</option>                            
                                            </select>
                                        </div><br>
                                        <center><button type="submit" class="btn btn-success" name="crear"><strong></i>INGRESAR</strong></button></center>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </body>

    </html>
    <?php
}
?>

