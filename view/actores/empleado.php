
<?php
session_start();
include_once('controller/C_Empleado.php');
include_once('view/page/FormHorizontal.php');

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
            <div class="container-fluid">
                <?php
                cabecera_body();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php
                            $id_tab = "id_empleado";
                            $nObj = new C_Empleado ();
                            $campos = $nObj->getCampos();
                            $numCampos = count($campos);
                            $est = NULL;
                            $numCampoVisible = 0;
                            if (isset($_POST['btnEstado']) and ! empty($_POST['btnEstado'])) {
                                $estado = $nObj->cambiarEstado();
                            }
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
                            ?>                        
                            <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <?php
                                // envia datos y obtiene la cabecera de la tabla
                                $array = array();
                                for ($i = 0; $i < $numCampos; $i++) {
                                    $array[$i] = "10";
                                }
                                getHeadTable($campos, $numCampoVisible, $array, $id_tab);

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
                                                if (($campo[1] != "timestamp") and ( $campo[0] != $id_tab)) {

                                                    if ($campo[0] == "estado") {
                                                        echo '<td ><center>' . estado($col[0], $col[$i]) . '</center></td>';
                                                    } else {
                                                        echo '<td ><center>' . $col[$i] . '</center></td>';
                                                    }
                                                }
                                                $i++;
                                            }
                                        }
//                                         <!--BOTOTES PARA ELIMINAR Y ACTUALOZAR-->
                                        $id = $col[0];
                                        boton_editar_eliminar($id);
                                        echo '</tr>';
                                        formulario_eliminar($col[0], $col[1]);
                                        // ------------ Div Para Actualizar Registros --------------                                               
                                        getDivActualizar($col[0], $col, $campos, $numCampoVisible, $numCampos, $id_tab);
                                    }
                                }
                                ?>
                            </table>
                        </div><!--class="table-responsive"-->
                    </div><!--class="col-md-12"-->
                </div> <!-- class="row"-->
            </div> <!--container-fluid-->
            <?php
//                        Llama a Div para nuevo registro
            getDivNew($campos, $numCampoVisible, $numCampos, $id_tab);
            ?>
        </body>
    </html>
    <?php
}
?>
