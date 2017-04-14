<?php
session_start();

if (isset($_SESSION['s_id_usuario'])) {
    header('location:index.php?pag=0');
} else {
    ?>
    <!DOCTYPE html>
    <html lang = "es">
        <head>
            <?php require_once 'vista/pag/head.php'; ?>  
            <style>
                body{
                    /*                    background-image: url(extras/img/fondoP.png);
                                        background-position: center center;
                                        background-repeat: no-repeat;
                                         background-size: cover;*/
                    background-color: #464646;
                }
            </style>
        </head>

        <body>
            <div class="container">   
                <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info" >

                        <div class="panel-heading">
                            <div class="panel-title">INGREASAR</div>
                            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">¿Olvidó su contraseña?</a></div>
                        </div>     
                        <div style="padding-top:30px" class="panel-body" >
                            <div class="row">
                                <div class="col-md-8" >

                                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                                    <form id="loginform" class="form-horizontal" role="form" action="index.php" method="POST">
                                        <!-- USUARIO -->
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            <input id="login-username" type="text" class="form-control" name="usuario" value="" placeholder="Usuario o email" required>                                        
                                        </div>
                                        <!-- CONTRASEÑA -->
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="login-password" type="password" class="form-control" name="passw" placeholder="contraseña" required>
                                        </div>

                                        <div class="input-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="login-remember" type="checkbox" name="remember" value="1"> ¿GUARDAR CREDENCIALES?
                                                </label>
                                            </div>
                                        </div>


                                        <div style="margin-top:10px" class="form-group">
                                            <!-- Button -->
                                            <div class="col-sm-12 controls" >                                    
                                                <button id="btnlogin" name="btnlogin" type="submit" class="btn btn-success">INGRESAR</button>                                    
                                                <!--<a id="btn-fblogin" href="#" class="btn btn-primary" disabled="true">Login con Facebook</a>-->

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12 control">
                                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                                    ¿No tienes una cuenta?.! 
                                                    <a href="#" onClick="$('#loginbox').hide();
                                                            $('#signupbox').show()">
                                                        Regístrate Aquí
                                                    </a>
                                                </div>
                                            </div>
                                        </div>           
                                    </form>  
                                    <?php
                                    if (isset($_POST['btnlogin'])) {
                                        require_once 'controlador/seguridad/C_Usuario.php';
                                        $nC_Usuario = new C_Usuario();
                                        if ($nC_Usuario->login_controlador()) {
//                                    header('location:index.php?pag=0');
                                            echo "<script type=text/javascript>
                                                    window.location='index.php?pag=0';
                                                  </script>";
                                        } else {
                                            echo '<div class="alert alert-danger">
                                                    <strong>Error!</strong> Usuario o Contraseña Incorrecto.
                                          </div>';
                                        }
                                    }
                                    ?>


                                </div>  
                                <div class="col-md-4">
                                    <img src="extras/img/candado3.jpg" class="img-thumbnail"  >
                                </div>

                            </div>  


                        </div>
                    </div>


                </div>
                <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Regístrese</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Ingresar</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">

                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Correo</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Correo Electrónico">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nombres" placeholder="Nombres">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="Apellidos" placeholder="Apellidos">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Contraseña">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Codigo de Invitacion</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="icode" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Registrar</button>                                    
                                    </div>
                                </div>

                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">

                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary" disabled="true"><i class="icon-facebook"></i>   Ingreasar Facebook</button>
                                    </div>                                           

                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </body>
    </html>
    <?php
}
?>


