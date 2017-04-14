<?php
session_start();
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
                <div class="row" align="center">
                    <div class="col-lg-6 col-md-offset-3" >
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>CAMBIAR CONTRASEÑA</h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-8">


                                    <form id="loginform" class="form-horizontal" role="form" action="index.php?pag=101" method="POST">

                                        <!-- CONTRASEÑA ANTERIOR -->
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"> </i> </span>
                                            <input id="contra" type="password" class="form-control" name="contra" value="" placeholder="Contraseña Anterior" required>                                        
                                        </div>
                                        <!-- NUEVA CONTRASEÑA -->                                
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="c1" type="password" class="form-control" name="c1" placeholder="Nueva Contraseña " required>
                                        </div>
                                        <!-- REPITA CONTRASEÑA --> 
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="c2" type="password" class="form-control" name="c2" placeholder="Repita la Contraseña" required>
                                        </div>
                                        <!-- BOTON CAMBIAR --> 
                                        <div style="margin-top:10px" class="form-group">
                                            <!-- Button -->
                                            <div class="col-sm-12 controls" >                                    
                                                <button id="btnlogin" name="btnCambiar" type="submit" class="btn btn-success">CAMBIAR</button>                                                                                
                                            </div>
                                        </div>

                                        <?php
                                        if (isset($_POST['btnCambiar'])) {
                                            require_once 'controlador/seguridad/C_Usuario.php';
                                            $nObj = new C_Usuario();
                                            if ($resultado = $nObj->cambiar_pssw()) {
                                                echo '<div class="alert alert-info" align="center">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Contraseña!</strong> Actualizada con exito
					</div>';
                                            } else {
                                                echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Contraseña!</strong> Digitada no corresponde a la antigua
					</div>';
                                            }
                                        }
                                        ?>
                                    </form> 

                                </div>
                                <div class="col-md-4">
                                    <h3><img src="extras/img/cambio_clave.jpg" class="img-circle img-polaroid" width="150" height="150"> </h3>
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
