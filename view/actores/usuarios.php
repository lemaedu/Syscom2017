<?php
if (!isset($_SESSION)) {
    session_start();
    include_once('controlador/seguridad/C_Usuario.php');
    include_once('controlador/seguridad/C_Rol.php');
    include_once('extras/Class/funciones.php');

    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?php require_once 'vista/pag/head.php'; ?>  
        </head>
        <body data-spy="scroll" data-target=".bs-docs-sidebar">
            <div align="center" class="container">
                <table width="95%" border="0">
                    <tr>
                        <td>
                            <table class="table table-bordered" >
                                <tr>
                                    <td>
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <h3>
                                                    <img src="extras/img/listado_papeleria.jpg" class="img-polaroid img-polaroid"  > 
                                                    LISTADO DE PRODUCTOS
                                                </h3>
                                            </div>
                                            <div class="span6">
                                                <div align="right">
                                                    <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                                                        <strong><i class="icon-user"></i> Ingresar Nuevo</strong>
                                                    </a>
                                                    <div class="btn-group">
                                                        <button class="btn" data-toggle="dropdown">
                                                            <i class="icon-search"></i> <strong>Consultar por</strong> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php
//                                                            $nObj = new C_r();
//                                                            $resultado = $nObj->listar();
//                                                            if ($resultado != NULL) {
//                                                                foreach ($resultado as $col) {
//                                                                    
                                                            ?>
                                                            <li ><a href="productos.php?categoria=////<?php // echo $col['id_categoria']       ?>" > <?php // echo $col['nombres']    ?></a></li>                                                                    
                                                            //<?php
//                                                                }
//                                                            }
                                                            ?>
                                                            <li><a href="productos.php?categoria=0">Todos</a></li>
                                                        </ul>
                                                    </div><br><br>
                                                    <!-- ------------------------- FORMMULARRIO PARA BUSQUEDA-------------------------->
                                                    <form accept-charset="utf-8" method="POST" name="form1" action="">
                                                        <div class="input-prepend">
                                                            <span class="add-on"><i class="icon-search"></i></span>
                                                            <input name="buscar" id="buscar" type="text" placeholder="Buscar producto" class="input-xlarge" autocomplete="off" onKeyUp="buscar();">
                                                        </div>
                                                    </form>
                                                    <div id="resultadoBusqueda"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if (isset($_POST['crear'])) {
                                $nObj = new C_Usuario();
                                if ($nObj->crear()) {
                                    Ingreso_Ok();
                                } else {
                                    Ingreso_error();
                                }
                            }
                            if (isset($_POST['actualizar'])) {
                                $nObj = new C_Usuario ();
                                if ($nObj->actualizar()) {
                                    actualizar_Ok();
                                } else {
                                    actualizar_error();
                                }
                            }
                            if (isset($_POST['eliminar'])) {
                                $nObj = new C_Usuario ();
                                if ($nObj->eliminar()) {
                                    eliminar_Ok();
                                } else {
                                    eliminar_error();
                                }
                            }
                            ?>
                            <table class="table table-bordered table table-hover">
                                <tr class="success" align="center">                                    
                                    <td width="15%"><strong>USUARIO</strong></td>                        
                                    <td width="25%"><strong>NOMBRES</strong></td>
                                    <td width="10%"><strong>ID_ROL</strong></td>
                                    <td width="10%"><strong>ROL</strong></td>
                                    <td width="10%"><strong>ESTADO</strong></td>
                                    <td width="10%"><strong></strong></td>
                                </tr>
                                <?php
                                $nObj = new C_Usuario ();

                                if (empty($_POST['buscar'])) {
                                    $resultados = $nObj->listar();
                                } else {
                                    $resultados = $nObj->buscar();
                                }

                                if ($resultados != NULL) {
                                    foreach ($resultados as $fila) {
                                        ?>
                                        <!---------------------AQUI SE IMPRIME TODAS LAS COLUMNAS DE LA TABLA----------------->
                                        <tr>

                                            <td><i class="icon-user"></i> <?php echo $fila['id_usuario'] ?></td>
                                            <td><?php echo $fila['usuario'] ?></td>
                                            <td><?php echo $fila['id_rol'] ?></td>
                                            <td><?php echo $fila['rol'] ?></td>                                            
                                            <td><?php echo $fila['estado'] ?></td>                                            
                                            <td>
                                                <a href="#actualizar<?php echo $fila['id_usuario_rol'] ?>" role="button" class="btn btn-mini" data-toggle="modal" title="ACTUALIZAR">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                <a href="#eliminar<?php echo $fila['id_usuario_rol'] ?>" role="button" class="btn btn-mini" data-toggle="modal" title="ELIMINAR" >
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!----------------------------------FORMULARIO ELIMINAR-------------------------------->
                                        <div id="eliminar<?php echo $fila['id_usuario_rol'] ?>" 
                                             class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                <input type="hidden" name="id" value="<?php echo $fila['id_usuario'] ?>">

                                                <div class="modal-body alert-danger">

                                                    <div class="alert-danger" align="center">ESTA SEGURO QUE DESEA ELIMINAR EL EQUIPO</div>
                                                    <div align="center"><?php echo $fila['id_usuario'] . ' ' . $fila['usuario'] ?></div><br>

                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <center><button type="submit" class="btn" name="cancelar" ><strong><i class="icon-stop"></i> CANCELAR</strong></button></center>
                                                        </div>
                                                        <div class="span6">

                                                            <center><button type="submit" class="btn btn-danger" name="eliminar" ><strong><i class="icon-trash"></i> ELIMINAR EQUIPO</strong></button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-----------------------------------FORMULARIO ACTUALIZAR---------------------------------->
                                        <div id="actualizar<?php echo $fila['id_usuario_rol'] ?>" 
                                             class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                <input type="hidden" name="id_usuario_rol" value="<?php echo $fila['id_usuario_rol'] ?>">
                                                <input type="hidden" name="id_usuario" value="<?php echo $fila['id_usuario'] ?>">
                                                <input type="hidden" name="id_rol" value="<?php echo $fila['id_rol'] ?>">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">ACTUALIZAR EQUIPO</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row-fluid">
                                                        <div class="span6">                                            
                                                            <strong>USUARIO</strong><br>
                                                            <textarea class="form-control" rows="2" name="descripcion" ><?php echo $fila['usuario']; ?></textarea><br>                                                            
                                                            <strong>ESTADO</strong><br>
                                                            <div class="form-group">                        
                                                                <select class="form-control" name="estado">
                                                                    <option value="A">ACTIVO</option>
                                                                    <option value="X">DESACTIVO</option>                            
                                                                </select>
                                                            </div><br><br>
                                                        </div>
                                                        <div class="span6">
                                                            <strong>ROL</strong><br>
                                                            <div class="form-group">                        
                                                                <select class="form-control" name="rol">
                                                                    <option value="<?php echo $fila['id_rol'] ?>"><?php echo $fila['rol']; ?></option>
                                                                    <?php
                                                                    $nObj = new C_Rol();
                                                                    $resultado1 = $nObj->listar();
                                                                    if ($resultado1 != NULL) {
                                                                        foreach ($resultado1 as $fil) {
                                                                            ?>
                                                                            <option value="<?php echo $fil['id_rol'] ?>"><?php echo $fil['rol']; ?></option>                                                                           
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div><br><br>
                                                            <center><button type="submit" class="btn btn-success" name="actualizar"><strong><i class="icon-ok"></i>ACTUALIZAR</strong></button></center>

                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
                                                </div>
                                            </form>
                                        </div>
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
                        </td>
                    </tr>
                </table>
                <div class="pagination">
                    <ul>
                        <?php
                        // Aqui va el codigo para crear paginacion
                        ?>
                    </ul>
                </div>
            </div>
            <!------------------------------FORMULARIO NUEVO-------------------------------->
            <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <form name="form2" method="post" enctype="multipart/form-data" action="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">FORMULARIO DE INGRESO</h3>
                    </div>
                    <div class="modal-body">

                        <div class="row-fluid">
                            <div class="span6" >
                                <strong>DESCRIPCION</strong><br>                            
                                <textarea class="form-control" rows="2" name="descripcion" ></textarea><br>
                                <strong>CANTIDAD</strong><br>
                                <input type="text" name="cantidad" autocomplete="off" ><br>
                                <strong>PRECIO COMPRA</strong><br>
                                <input type="text" name="precio_compra" autocomplete="off" ><br>                                

                            </div>
                            <div class="span6" align="center">
                                <strong>DESCUENTO</strong><br>
                                <div class="form-group">                        
                                    <select class="form-control" name="descuento">
                                        <option value="0.01">1%</option>
                                        <option value="0.02">3%</option>
                                        <option value="0.03">3%</option>
                                        <option value="0.04">4%</option>
                                        <option value="0.05">5%</option>
                                        <option value="0.06">6%</option>
                                        <option value="0.07">7%</option>
                                        <option value="0.08">8%</option>
                                        <option value="0.09">9%</option>
                                        <option value="0.10">10%</option>
                                        <option value="0.12">12%</option>
                                        <option value="0.14">14%</option>
                                        <option value="0.15">15%</option>
                                        <option value="0.20">20%</option>
                                        <option value="0.22">22%</option>
                                    </select>
                                </div><br><br>
                                <center><button type="submit" class="btn" name="crear"><strong><i class="icon-ok"></i>INGRESAR</strong></button></center>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
                    </div>
                </form>
            </div>
        </body>
    </html>
    <?php
}
?> 