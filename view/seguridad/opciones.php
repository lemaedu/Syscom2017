<?php
session_start();
if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?php require_once 'view/page/head.php'; ?>  
        </head>
        <body>
            <?php require_once 'view/page/menu.php'; ?>
            <div class="container">
                <hr>
                <div class="row">

                    <div class="col-lg-4 col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">                           
                                    <div class="col-xs-9 text-left">                                    
                                        <div>OPCIONES!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="panel-group" id="panel-1">

                                    <?php
                                    require 'controller/segurity/C_Opciones.php';
                                    $nObj = new C_Opciones();
                                    $result = $nObj->listar();
                                    if ($result != NULL) {
                                        $grupo = ""; /* ---CONTENIDO SUPERIOR del menu---- */
                                        $opciones = ""; /* ---CONTENIDO INFERIOR DENTRO DEL GRUPO */
                                        $p = 0;
                                        $j = 0;
                                        foreach ($result as $fila) {
                                            $opciones = $fila["opcion"];
                                            $contenido = $fila["contenido"];
                                            if ($grupo != $fila["grupo"]) {
                                                $i = 0;
                                                if ($i == $p) {
                                                    $grupo = $fila["grupo"];
                                                    echo '  <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <a class="panel-title" data-toggle="collapse" data-parent="#panel-1" href="#' . $j . '">' . $grupo . '</a>
                                                            </div>                                                            
                                                            <div id="' . $j . '" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    ' . $opciones . '
                                                                </div>';
                                                    $i++;
                                                    $p = $i;
                                                } else {
                                                    $grupo = $fila["grupo"];
                                                    echo ' </div> </div>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <a class="panel-title" data-toggle="collapse" data-parent="#panel-1" href="#' . $j . '">' . $grupo . '</a>
                                                            </div>
                                                            <div id="' . $j . '" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    ' . $opciones . '
                                                                </div>';
                                                    $i++;
                                                    $p = $i;
                                                }
                                                $j++;
                                            } else {
                                                echo '<div class="panel-body">
                                                        ' . $opciones . '
                                                    </div>';

                                                $i++;
                                                $p = $i;
                                            }
                                        }
                                        echo '</div></div>';
                                    }
                                    ?> 
                                </div>

                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-archive fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>Prod. Vendidos!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </body>
    </html>
    <?php
}
?>
