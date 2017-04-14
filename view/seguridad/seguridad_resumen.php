<?php
session_start();
include_once('controlador/seguridad/C_Menu.php');
include_once('vista/pag/FormHorizontal.php');
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    
    $nObj = new C_Menu ();
    if (isset($_POST['btnEstado']) and ! empty($_POST['btnEstado'])) {        
        $estado = $nObj->cambiarEstado();
    }
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
                });
            </script>

        </head>
        <body>
            <?php require_once 'vista/pag/menu.php'; ?>
            <div class="container">
                <?php
                cabecera_body();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php
                             
                            if (isset($_POST['ingresar'])) {                               
                                if ($nObj->crear()) {
                                    mensaje_add_ok();
                                } else {
                                    mensaje_add_error();
                                }
                            }
                            if (isset($_POST['actualizar'])) {                                
                                if ($nObj->actualizar()) {
                                    mensaje_act_ok();
                                } else {
                                    mensaje_act_error();
                                }
                            }
                            if (isset($_POST['eliminar'])) {                                
                                if ($nObj->eliminar()) {
                                    mensaje_eliminar_ok();
                                } else {
                                    mensaje_eliminar_error();
                                }
                            }
//                        
                            ?>
                            <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="info">   
                                        <?php                                        
                                        $campos = $nObj->getCampos();
                                        $numCampoVisible = 0;
                                        $numCampos = count($campos);
                                        $array = array("5%", "5%", "15%", "15%", "15%", "5%");
                                        if ($campos != NULL) {
                                            $i = 0;
                                            //---------------------cabecera de la tabla-----------
                                            foreach ($campos as $campo) {
                                                if (($campo[1] != "timestamp") and ( $campo[0] != "imagen")) {

                                                    echo '<td width="' . $array[$i] . '"><center><strong>' . strtoupper($campo[0]) . '</strong></center></td>';
                                                    $numCampoVisible++;
                                                }
                                                $i++;
                                            }
                                            echo "<td width='10%'><center><strong>ACCIONES</strong></center></td>";
                                        }
                                        ?>                                    
                                    </tr>
                                </thead>
                                <?php
                                //---------------CUERPO DE LA TABLA  ----------------  
                                if (empty($_POST['buscar'])) {
                                    $resultados = $nObj->listar();
                                } else {

                                    $resultados = $nObj->buscar();
                                }
                                if ($resultados != NULL) {
                                    foreach ($resultados as $col) {
                                        echo '<tr>';
                                        for ($i = 0; $i < $numCampos; $i++) {
                                            foreach ($campos as $campo) {
                                                if (($campo[1] != "timestamp")  and ( $campo[0] != "imagen")) {

                                                    if ($campo[0] == "estado") {
                                                        echo '<td ><center>' . estado($col[0],$col[$i]) . '</center></td>';
                                                    } else {
                                                        echo '<td ><center>' . $col[$i] . '</center></td>';
                                                    }
                                                }
                                                $i++;
                                            }
                                        }
//                                         <!--BOTOTES PARA ELIMINAR Y ACTUALOZAR-->
                                        $id = $col[0];
                                        boton_editar_eliminar($id)
                                        ?>
                                        </tr>

                                        <!-------ELIMINAR REGISTRO------------------------------------------- -->

                                        <?php formulario_eliminar($col[0], $col[1]) ?>

                                        <!-------actualizar registro------------------------------------------- -->
                                        <div id="actualizar<?php echo $col[0] ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form name="form2" method="post" enctype="multipart/form-data" action="">
                                                        <input type="hidden" name="id" value="<?php echo $col[0] ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">ACTUALIZAR REGISTRO</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-6">
                                                                <?php
                                                                if ($campos != null) {
                                                                    $j = 0;
                                                                    foreach ($campos as $campo) {
                                                                        if ($j == (round((($numCampoVisible + $numCampos) / 2) / 2))) {
                                                                            echo '</div><div class="col-md-6">';
                                                                        }
                                                                        if (($campo[1] != "timestamp") and ( $campo[0] != "id_grupo")and ( $campo[0] != "estado")) {
                                                                            if ($campo[0] == "descripcion") {
                                                                                txt_textarea($campo[0], $col[$j]);
                                                                            } else {
                                                                                txt_input($campo[0], "text", $col[$j]);
                                                                            }
                                                                        }
                                                                        $j++;
                                                                    }
                                                                }
                                                                ?>                                                            
                                                            </div>&nbsp;                                                        
                                                            <center><button type="submit" class="btn btn-success" name="actualizar"><strong><span class="glyphicon glyphicon-ok"></span>ACTUALIZAR</strong></button></center>
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
            <!-- nuevo registro  -->

            <div id="nuevo" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <form name="form2" method="post" enctype="multipart/form-data" action="">                   
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> INGRESAR REGISTRO</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-6">
                                    <?php
                                    if ($campos != null) {
                                        $j = 0;
                                        foreach ($campos as $campo) {
                                            if ($j == (round((($numCampoVisible + $numCampos) / 2) / 2))) {

                                                echo '</div><div class="col-md-6">';
                                            }
                                            if (($campo[1] != "timestamp") and ( $campo[0] != "id_grupo")and ( $campo[0] != "estado")) {
                                                if ($campo[0] == "descripcion") {
                                                    txt_textarea($campo[0], "");
                                                } else {
                                                    txt_input($campo[0], "text", "");
                                                }
                                            }
                                            $j++;
                                        }
                                    }
                                    ?>                                                            
                                </div>&nbsp;                                                        
                                <center><button type="submit" class="btn btn-success" name="ingresar"><strong><span class="glyphicon glyphicon-ok"></span> INGRESAR</strong></button></center>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </body>
    </html>
    <?php
}
?>

