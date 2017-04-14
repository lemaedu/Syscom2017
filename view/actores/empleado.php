
<?php
session_start();
include_once('controlador/C_Empleado.php');
include_once('vista/pag/FormHorizontal.php');

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php require_once 'vista/pag/head.php'; ?>  

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
                            $nObj = new C_Empleado();
                            $campos = $nObj->getCampos();
                            $numCampos = count($campos);
                            $numCampoVisible = 0;


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
                            <table class="table table-bordered table-hover">
                                <tbody>                          
                                    <tr class="success">   
                                        <?php
                                        $array = array("5%", "10%", "10%", "5%", "5%", "5%", "5%", "5%", "5%", "5%", "5%", "5%", "5%");
                                        if ($campos != NULL) {
                                            $i = 0;
                                            //---------------------cabecera de la tabla-----------
                                            foreach ($campos as $campo) {
                                                if (($campo[1] != "timestamp") and ( $campo[1] != "char(1)") and ( $campo[0] != "nacionalidad") and ( $campo[0] != "correo")
                                                        and ( $campo[0] != "nacimiento") and ( $campo[0] != "foto")) {
                                                    echo '<td width="' . $array[$i] . '"><center><strong>' . ucwords(($campo[0])) . '</strong></center></td>';
                                                    $numCampoVisible++;
                                                }
                                                $i++;
                                            }
                                            echo "<td width='10%'><center></center></td>";
                                        }
                                        ?>                                    
                                    </tr>
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
                                            for ($i = 0; $i < $numCampos;) {
                                                foreach ($campos as $campo) {
                                                    if (($campo[1] != "timestamp") and ( $campo[1] != "char(1)") and ( $campo[0] != "nacionalidad") and ( $campo[0] != "correo")
                                                            and ( $campo[0] != "nacimiento")and ( $campo[0] != "foto")) {

                                                        echo '<td >' . $col[$i] . '</td>';
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
                                                                        if ($campo[1] != "timestamp") {
                                                                            if ($campo[0] == "direccion") {
                                                                                txt_textarea($campo[0], $col[$j]);
                                                                            } else {
                                                                                if ($campo[1] == "date") {
                                                                                    txt_calendario($campo[0], $col[$j]);
                                                                                } else {
                                                                                    txt_input($campo[0], "text", $col[$j]);
                                                                                }
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
                                </tbody>
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
                                            if ($campo[1] != "timestamp") {
                                                if ($campo[0] == "direccion") {
                                                    txt_textarea($campo[0], "");
                                                } else {
                                                    if ($campo[1] == "date") {
                                                        txt_calendario1($campo[0], "");
                                                    } else {
                                                        txt_input($campo[0], "text", "");
                                                    }
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
