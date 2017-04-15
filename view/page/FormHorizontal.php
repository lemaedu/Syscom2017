<?php

class FormHorizontal {

    public $nombre;
    public $placeholder;
    public $valor;

    function __construct() {
        
    }

    function crearGrupo_H() {
        $nombre1 = strtoupper($this->nombre);
        echo "<div class=form-group>
                <label class='control-label col-sm-3' for='$this->nombre'> $nombre1:</label>
                    <div class='col-sm-7'>
                        <input type='text' value='$this->valor' name='$this->nombre' class='form-control' id='$this->nombre' placeholder='$this->placeholder'>
                    </div>
                </div>";
    }

    function crearBoton() {
        $nombre1 = strtoupper($this->nombre);
        echo "<div class='form-group'>
                <div class='col-sm-offset-2 col-sm-10'>
                    <button type='submit' name='$this->nombre' class='btn btn-default'>$nombre1</button>
                </div>
              </div>";
    }

    function txt_calendario() {
        ?> 
        <div class=form-group>
            <label class='control-label col-sm-3' for='<?php $this->nombre ?>'> <?php $this->nombre ?>:</label>
            <div class='col-sm-7'>
                <input type='text' value='<?php $this->valor ?>' name='<?php $this->nombre ?>' class='form-control' id='fecha'>
            </div>
        </div>
        <script type="text/javascript">
            // Cuando el Doc este listo
            $(document).ready(function () {
                $('#fecha').datepicker({
                    format: "yyyy-mm-dd"
                });
            });
        </script> 
        <?php
    }

}


//Diva para Actualizar Registrso-----
function getDivActualizar($col_0, $col, $campos, $numCampoVisible, $numCampos, $id_valor) {
    ?>
    <div id="actualizar<?php echo $col_0 ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form name="form" method="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="id" value="<?php echo $col_0 ?>">
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
                                    if (($campo[1] != "timestamp") and ( $campo[0] != $id_valor)and ( $campo[0] != "estado")) {
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

function getDivNew($campos, $numCampoVisible, $numCampos, $id_valor) {
    ?>
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
                                    if (($campo[1] != "timestamp") and ( $campo[0] != $id_valor)and ( $campo[0] != "estado")) {
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
    <?php
}

function getBodyTable() {
    echo '
        <tbody>
            <tr> 
                <td> </td>
            </tr>
        <tbody>
    ';
}

function getHeadTable($dato, $numCampoVisible, $array,$id_tab) {
    ?>    
    <thead>
        <tr class="success"> 
            <?php
            if ($dato != NULL) {
                $i = 0;
                //---------------------cabecera de la tabla-----------
                foreach ($dato as $campo) {
                    if (($campo[1] != "timestamp") and ( $campo[0] != $id_tab)) {
                        echo '<td width="' . $array[$i] . '"><center><strong>' . strtoupper($campo[0]) . '</strong></center></td>';
                        $numCampoVisible++;
                    }
                    $i++;
                }
                echo "<td width='10%'><center>ACCIONES</center></td>";
            }
            ?>
        </tr>
    </thead> 
    <?php
}

function getTabala($datos) {
    echo '
    <div class="table-responsive">
        <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">            
            ';
}

function getDiv($tipo, $titulo, $datos) {
    echo
    '<div class = "panel panel-' . $tipo . '">
        <div class = "panel-heading">
            <h3 class = "panel-title">' . $titulo . '</h3>
        </div>
        <div class = "panel-body">
                    ' . $datos . '
        </div>
    </div>';
}

function mensaje_add_ok() {
    echo'<div class="alert alert-info" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong> Registrado con Èxito en la Base de Datos</strong>
            </div>';
}

function mensaje_add_error() {
    echo '  <div class="alert alert-danger" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Error en Registro</strong>
            </div>';
}

function mensaje_act_ok() {
    echo '	<div class="alert alert-info" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>ACTUALIZADO CORRECTAMENTE</strong>
            </div>';
}

function mensaje_act_error() {
    echo '  <div class="alert alert-danger" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>ERROR EN ACTUALIZAR</strong>
            </div>';
}

function mensaje_eliminar_error() {
    echo '  <div class="alert alert-danger" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>ERROR EN ELIMINAR</strong>
            </div>';
}

function mensaje_eliminar_ok() {
    echo '  <div class="alert alert-info" align="center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>ELIMINADO DE LA BASE DE DATOS</strong>
            </div>';
}

function getBtnEditarEliminar($id, $cod_b, $cod_cat, $cat, $des, $cod_mar, $mar) {
    ?>
    <td>                
        <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#actualizar"<?php echo $id . ' id="' . $id . '" codigo_barras="' . $cod_b . '" cod-cat="' . $cod_cat . '" cat="' . $cat . '" descripcion="' . $des . '" cod-mar="' . $cod_mar . '" marca="' . $mar . '"'; ?>><span class="glyphicon glyphicon-edit"></span></button>
        <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#actualizar"<?php echo $id . 'id="' . $id . '"'; ?>><span class="glyphicon glyphicon-trash"></span></button>
        <a href = "#actualizar<?php echo $id ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal"><span class="glyphicon glyphicon-edit"></span></a>
        <a href = "#eliminar<?php echo $id ?>" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
    </td>
    <?php
}

function boton_editar_eliminar($id) {
    echo ' <td>
                <a href="productos/actuliazarProd.php#actualizar' . $id . '" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="Actualizar">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="#eliminar' . $id . '" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="Eliminar" >
                    <span class="glyphicon glyphicon-trash"></span>                    
                    </a>
            </td>';
}

function boton_pdf($id) {
    echo ' 
        <td>                                
            <a href="index.php?pag=21&fact=' . $id . '" target="_blank" role="button" class="btnbtn-xs btn-default" data-toggle="modal" title="PDF">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
            </a>
        </td>';
}

function cabecera_body() {
    ?>
    <div class="row">                    
        <div class="col-md-12">            
            <div class="col-md-4">
                <a href="#nuevo" class="btn btn-primary" role="button" data-toggle="modal">
                    <span class="glyphicon glyphicon-file"></span> Nuevo
                </a>
                <a href="#" role="button" class="btn btn-toolbar" data-toggle="modal" title="Imprimir">
                    <span class="glyphicon glyphicon-print"></span>
                </a> 
                <a href="#" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </a>
                <a href="#" role="button" class="btn btn-lg" data-toggle="modal" title="PDF">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
            </div>  
        </div>
    </div>
    <hr>
    <?php
}

function formulario_eliminar($id, $nombre) {
    ?>
    <div id="eliminar<?php echo $id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form name="form2" method="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ELIMINAR REGISTRO</h4>
                    </div>
                    <div class="modal-body alert-danger">

                        <div class="alert-danger" align="center">¿ESTA SEGURO QUE DESEA ELIMINAR?</div>
                        <div align="center"><?php echo $id . ' ' . $nombre ?></div><br>

                        <div class="row">
                            <div class="col-md-6">
                                <center><button type="submit" class="btn" name="cancelar" ><strong><i class="icon-stop"></i> CANCELAR</strong></button></center>
                            </div>
                            <div class="col-md-6">

                                <center><button type="submit" class="btn btn-danger" name="eliminar" ><strong><i class="icon-trash"></i> ELIMINAR </strong></button></center>
                            </div>
                        </div>


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

function txt_input($nombre, $tipo, $valor) {
    $nom = strtoupper($nombre);
    ?>
    <strong><?php echo $nom; ?></strong><br>                                                                
    <input class="form-control" type="<?php echo $tipo; ?>" name="<?php echo $nombre; ?>" id="<?php echo $nombre; ?>"
           autocomplete="off" value="<?php echo $valor; ?>" placeholder="Ingrese: <?php echo $nombre; ?>"/>
           <?php
       }

       function txt_textarea($nombre, $valor) {
           $nom = strtoupper($nombre);
           ?>
    <strong><?php echo $nom; ?></strong><br>                                                                
    <textarea class="form-control"  name="<?php echo $nombre; ?>" id="<?php echo $nombre; ?>"
              rows="2"><?php echo $valor; ?></textarea>
              <?php
          }

          function txt_calendario($nombre, $valor) {
              $nom = strtoupper($nombre);
              ?> 
    <div class="hero-unit">
        <strong><?php echo $nom; ?></strong><br>  
        <input  class="form-control" type="text" name="<?php echo $nombre; ?>" placeholder="aaa-mm-dd"  value="<?php echo $valor; ?>" id="fecha">

    </div>
    <script type="text/javascript">
        // Cuando el Doc este listo
        $(document).ready(function () {
            $('#fecha').datepicker({
                format: "yyyy-mm-dd"
            });
        });
    </script>      
    <?php
}

function txt_calendario1($nombre, $valor) {
    $nom = strtoupper($nombre);
    ?> 
    <div class="hero-unit">
        <strong><?php echo $nom; ?></strong><br>  
        <input  class="form-control" type="text" name="<?php echo $nombre; ?>" placeholder="aaa-mm-dd"  value="<?php echo $valor; ?>" id="fecha1">
    </div>
    <script type="text/javascript">
        // Cuando el Doc este listo
        $(document).ready(function () {
            $('#fecha1').datepicker({
                format: "yyyy-mm-dd"
            });
        });
    </script>      
    <?php
}

function txt_calendario4($nombre, $valor) {
    $nom = strtoupper($nombre);
    ?> 
    <div class="hero-unit">
        <strong><?php echo $nom; ?></strong><br>  
        <input  class="form-control" type="text" name="fecha" placeholder="aaa-mm-dd"  value="<?php echo $valor; ?>" id="fecha4">
    </div>
    <script type="text/javascript">
        // Cuando el Doc este listo
        $(document).ready(function () {
            $('#fecha4').datepicker({
                format: "yyyy-mm-dd"
            });
        });
    </script>      
    <?php
}

function txt_calendario2($nombre, $valor) {
    $nom = strtoupper($nombre);
    ?> 
    <div class=form-group>
        <label class='control-label col-sm-3' for='<?php echo $nombre ?>'> <?php echo $nom ?>:</label>
        <div class='col-sm-7'>
            <input type='text' value='<?php echo $valor ?>' name='<?php echo $nombre ?>' class='form-control' id='fecha'>
        </div>
        <script type="text/javascript">
            // Cuando el Doc este listo
            $(document).ready(function () {
                $('#fecha').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true
                });
            });
        </script> 
    </div>

    <?php
}

function txt_calendario3($nombre, $valor) {
    $nom = strtoupper($nombre);
    ?> 
    <div class=form-group>
        <label class='control-label col-sm-3' for='<?php echo $nombre ?>'> <?php echo $nom ?>:</label>
        <div class='col-sm-7'>
            <input type='text' value='<?php echo $valor ?>' name='<?php echo $nombre ?>' class='form-control' id='fecha'>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#fecha').datepicker({
                    minDate: new Date(2017, 1, 1),
                    maxDate: new Date(2017, 12, 30),
                    viewMode: 'years',
                    format: 'dd-mm-yyyy',
                    todayHighlight: true,
                    autoclose: true
                });
            })
        </script>
    </div>

    <?php
}

#####formato de estados

function estado($id_m, $estado) {
    if ($estado == 'A') {
        return '
        <center>
        <form method="POST">
        <input type="hidden" name="estado" value="' . $estado . '">
            <button type="submit" class="btn btn-xs btn-success" name="btnEstado" value=' . $id_m . '><strong>Act</strong>                
             </button>
         </form>
        </center>';
    } else {
        return '<center>
                    <form method="POST">
                        <button type="submit" class="btn btn-xs btn-warning" name="btnEstado" value=' . $id_m . ' ><strong>Des</strong>
                        </button>
                    </form>        
                </center>';
    }
}

function estado1($id_m, $estado) {

    switch ($estado) {
        case '0'://Cerrado
            return '<center>
                    <form method="POST">
                    <input type="hidden" name="estado" value="' . $estado . '">
                        <button type="submit" class="btn btn-default btn-xs btn-danger" name="btnEstado" value=' . $id_m . ' >
                            <strong>Cerrado</strong>
                        </button>
                    </form>        
                </center>';
            break;
        case '1'://Abierto
            return '<center>
                    <form method="POST">
                    <input type="hidden" name="estado" value="' . $estado . '">
                        <button type="submit" class="btn btn-xs btn-success" name="btnEstado" value=' . $id_m . '>
                            <strong>Abierto</strong>
                        </button>
                    </form>
                  </center>';
            break;
        case '2'://Pendiente
            return '<center>
                    <form method="POST">
                    <input type="hidden" name="estado" value="' . $estado . '">
                        <button type="submit" class="btn btn-xs btn-warning" name="btnEstado" value=' . $id_m . '>
                            <strong>Pendiente</strong>
                        </button>
                    </form>
                  </center>';
            break;
        case '3'://Pagado
            return '<center>
                    <form method="POST">
                    <input type="hidden" name="estado" value="' . $estado . '">
                        <button type="submit" class="btn btn-xs btn-info" name="btnEstado" value=' . $id_m . '>
                            <strong>Pagado</strong>
                        </button>
                    </form>
                  </center>';
            break;
    }
}
