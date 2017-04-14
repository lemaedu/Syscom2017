<?php
session_start();

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <html lang = "es">
        <head>           
            <?php require_once 'vista/pag/head.php'; ?>
        </head>
        <body>
            <?php require_once 'vista/pag/menu.php'; ?>
            <div class="container">             
                <div class="row">
                    <?php
                    $vecPag=array('30','31','32','33','34','35');
                    $vec = array('primary', 'green', 'yellow', 'red', 'tomate', 'verde', 'plomo', 'morado');
                    $vecDoc = array('Fact', 'Nota', 'Recb', 'Tick');
                    $vecIco = array('file', 'list', 'list-alt', 'tasks');
                    for ($i = 0; $i <= 3; $i++) {
                        echo '    
                            <a href="index.php?pag='.$vecPag[$i].'">  
                                <div class="col-lg-1 col-md-2">
                                    <div class="panel panel-' . $vec[$i + 4] . '">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">                                                    
                                                    <span class="glyphicon glyphicon-' . $vecIco[$i] . ' fa-3x"></span>
                                                </div>
                                                <div class="col-xs-9 text-center">                          
                                                    <div>' . $vecDoc[$i] . '</div>
                                                </div>
                                            </div>
                                        </div>                                                                                                 
                                    </div>
                                </div>
                            </a>
                    ';
                    }
                    ?>
                </div>
            </div>
        </body>    
    </html>
    <?php
}
?>