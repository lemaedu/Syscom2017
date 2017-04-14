<?php
session_start();

if (isset($_SESSION['s_id_usuario'])) {
    header('location:index.php?pag=0');
} else {
    if (isset($_POST['btnlogin'])) {
        require_once 'controller/segurity/C_Usuario.php';
        $nC_Usuario = new C_Usuario();
        if ($nC_Usuario->login_controlador()) {
            header('location:index.php?pag=0');
        } else {
            echo '<div class="alert alert-danger">
                        <strong>Error!</strong> Usuario o Contraseña Incorrecto.
                    </div>';
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang = "es">
        <head>
            <?php require_once 'view/page/head.php'; ?>  
            <style>
                body{
                    /*background-image: url(resourse/img/glyphicons-halflings.png);*/
                    background-position: center center;
                    background-repeat: no-repeat;
                    background-size: cover;
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

                                        <div class="form-group">
                                            <label for="usuario" class="col-md-3 control-label">USUARIO</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Correo Electrónico">
                                            </div>
                                        </div>


                                        <!--                                        
                                                                                    
                                                                                    <div style="margin-bottom:25px" class="input-group">
                                                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>                                            
                                                                                        <div class="col-sm-9">
                                                                                            <input  type="text" class="form-control" id="usuario"  name="usuario" placeholder="Usuario o email" />
                                                                                        </div>
                                            
                                                                                    </div>-->
                                        <!-- CONTRASEÑA -->

                                        <div class="form-group">
                                            <label for="passw" class="col-md-3 control-label">PASSW: </label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="passw" id="passw" placeholder="Contraseña">
                                            </div>
                                        </div>
                                        <!--                                        <div style="margin-bottom: 25px" class="input-group">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                                                    <div class="col-sm-9">
                                                                                        <input id="passw" type="password" class="form-control" name="passw" placeholder="contraseña" >
                                                                                    </div>
                                                                                </div>-->

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
                                    ?>
                                </div>  
                                <div class="col-md-4">
                                    <img src="resourse/img/candado3.jpg" class="img-thumbnail" class="img-responsive" alt="Imagen responsive" >
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
                                <!--correo-->
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Correo</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="email" placeholder="Correo Electrónico">
                                    </div>
                                </div>
                                <!--Nombres-->
                                <div class="form-group">
                                    <label for="nombres" class="col-md-3 control-label">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nombres" placeholder="Nombres">
                                    </div>
                                </div>
                                <!--Apellidos-->
                                <div class="form-group">
                                    <label for="apellidos" class="col-md-3 control-label">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="apellidos" placeholder="Apellidos">
                                    </div>
                                </div>
                                <!--Contraseña-->
                                <div class="form-group">
                                    <label for="passwd" class="col-md-3 control-label">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Contraseña">
                                    </div>
                                </div>
                                <!--Codigo-->
                                <div class="form-group">
                                    <label for="codigo" class="col-md-3 control-label">Codigo de Invitacion</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="codigo" placeholder="X2jM1">
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
            <script src="resourse/jquery.validate/jquery.validate.min.js" type="text/javascript"></script>
            <script type="text/javascript">
    //                                $.validator.setDefaults({
    //                                    submitHandler: function () {
    //                                        alert("Ok!");
    //                                    }
    //                                });

                                $(document).ready(function () {

                                    $("#loginform").validate({
                                        rules: {
                                            usuario: "required",
                                            apellido: "required",

                                            usuario: {
                                                required: true,
                                                minlength: 2
                                            },
                                            passw: {
                                                required: true,
                                                minlength: 1
                                            },
                                            confirm_pass: {
                                                required: true,
                                                minlength: 1,
                                                equalTo: "#passw"
                                            },
                                            email: {
                                                required: true,
                                                email: true
                                            },
                                            agree: "required"
                                        },
                                        messages: {
                                            usuario: "Ingrese Usuario",
                                            apellido: "Ingrese Apellido",
                                            usuario: {
                                                required: "Ingrese Usuario",
                                                minlength: "Dede contener min 2 letras"
                                            },
                                            passw: {
                                                required: "Ingrese Contraseña",
                                                minlength: "Minimo 5 caracteres"
                                            },
                                            confirm_passw: {
                                                required: "Ingrese contraseña",
                                                minlength: "Minimo 5 caracteres",
                                                equalTo: "Ingrese Contraseñas iguales"
                                            },
                                            email: "Ingrese direccion valida",
                                            agree: "Acepta las Politicas"
                                        },
                                        errorElement: "em",
                                        errorPlacement: function (error, element) {
                                            // Add the `help-block` class to the error element
                                            error.addClass("help-block");

                                            // Add `has-feedback` class to the parent div.form-group
                                            // in order to add icons to inputs
                                            element.parents(".col-sm-9").addClass("has-feedback");

                                            if (element.prop("type") === "checkbox") {
                                                error.insertAfter(element.parent("label"));
                                            } else {
                                                error.insertAfter(element);
                                            }

                                            // Add the span element, if doesn't exists, and apply the icon classes to it.
                                            if (!element.next("span")[ 0 ]) {
                                                $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
                                            }
                                        },
                                        success: function (label, element) {
                                            // Add the span element, if doesn't exists, and apply the icon classes to it.
                                            if (!$(element).next("span")[ 0 ]) {
                                                $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
                                            }
                                        },
                                        highlight: function (element, errorClass, validClass) {
                                            $(element).parents(".col-sm-9").addClass("has-error").removeClass("has-success");
                                            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                                        },
                                        unhighlight: function (element, errorClass, validClass) {
                                            $(element).parents(".col-sm-9").addClass("has-success").removeClass("has-error");
                                            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                                        }
                                    });

                                });
            </script>
        </body>        
    </html>
    <?php
}
?>


