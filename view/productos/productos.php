<?php
session_start();
include_once('controller/productos/C_Producto.php');
include_once('controller/productos/C_Categoria.php');
include_once('controller/productos/C_Marca.php');

require_once ('view/page/FormHorizontal.php');


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
            <div class="container">
                <?php
                cabecera_body();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">

                            <?php
                            $nObj = new C_Producto();
                            if (isset($_POST['crear'])) {
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
                                    actualizar_error();
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
                            <table id="tabla" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="success" align="center">
                                        <td ><strong>Id</strong></td>
                                        <td ><strong>CODIGO_B</strong></td>
                                        <td ><strong>CATEGORIA</strong></td>
                                        <td ><strong>DESCRIPCION</strong></td>                                
                                        <td ><strong>MARCA</strong></td>                                                                
                                        <td ><strong></strong></td>
                                    </tr>
                                </thead>
                                <?php
                                if (empty($_POST['buscar_producto'])) {
                                    $resultados = $nObj->listar();
                                } else {
                                    $resultados = $nObj->buscar();
                                }
                                if ($resultados != NULL) {
                                    foreach ($resultados as $fila) {
                                        ?>
                                        <tr>
                                            <td><?php echo $fila[0] ?></td>
                                            <td><?php echo $fila[1] ?></td>
                                            <td><?php echo $fila[3] ?></td>
                                            <td><?php echo $fila[4] ?></td>
                                            <td><?php echo $fila[6] ?></td>                                        

                                            <?php
                                            $id = $fila[0];
                                            $cod_b = $fila[1];
                                            $cod_cat = $fila[2];
                                            $cat = $fila[3];
                                            $des = $fila[4];
                                            $cod_mar = $fila[5];
                                            $mar = $fila[6];
                                            getBtnEditarEliminar($id, $cod_b, $cod_cat, $cat, $des, $cod_mar, $mar)
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<div class="alert alert-info" align="center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>NO HAY REGISTROS POR MOSTRAR</strong>
					</div>';
                                }
                                ?>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </body>        
        <script src="resourse/js/app.js" type="text/javascript"></script>
        <script>
                $(document).ready(function () {
                    load(1);
                });
        </script>
        <?php
        require_once 'div.php';
        ?>

    </html>
    <?php
}
?>
