<?php
session_start();
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?php require_once 'view/page/head.php'; ?> 
        </head>
        <body>
            <?php require_once 'view/page/menu.php'; ?>
            <div class="container">
                <div class="row" align="center">
                    <div class="col-lg-8 col-md-offset-2" >
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>Actualizar Perfil</h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-8">
                                    <form class="form-horizontal" role="form" method="post" action="index.php?pag=102">
                                        <?php
                                        require_once 'view/page/FormHorizontal.php';
                                        require_once 'controller/actores/C_Empleado.php';
                                        $nConEm = new C_Empleado();

                                        if (isset($_POST['actualizar'])) {
                                            if ($res = $nConEm->actualizar()) {
                                                mensaje_act_ok();
                                            } else {
                                                mensaje_act_error();
                                            }
                                        }
                                        $resultado = $nConEm->buscarEmpleado();

                                        $a = new FormHorizontal();
                                        $array = array("cedula", "nombres", "apellidos",
                                            "f_nac", "sexo", "correo", "nacionalidad", "telefono", "direccion");
                                        $longitud = count($array);

                                        if ($resultado != NULL) {
                                            foreach ($resultado as $value) {
                                                for ($i = 0; $i < $longitud; $i++) {

                                                    if ($i == 3) {
                                                        txt_calendario2($array[$i], $value[$i]);
                                                    } else {
                                                        $a->valor = $value[$i];
                                                        $a->nombre = $array[$i];
                                                        $a->crearGrupo_H();
                                                    }
                                                    if ($i == 5) {
                                                        echo '<hr>';
                                                    }
                                                }
                                            }
                                        }
                                        $a->nombre = 'actualizar';
                                        $a->crearBoton();
                                        ?>
                                    </form>
                                </div>
                                <div class="col-md-4">

                                    <img src="resourse/img/cambio_clave.jpg" class="img-circle img-polaroid" width="150" height="150">
                                    <strong>FOTO </strong><br>                                                                
                                    <input class="form-control" type="file" name="foto" id="foto">                                    

                                </div>
                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
}
?>
