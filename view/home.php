<?php
require_once 'page/FormHorizontal.php';
session_start();

if (!isset($_SESSION['s_id_usuario'])) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang = "es">
        <head>                    
            <?php
            require_once 'view/page/head.php';
            ?>
        </head>
        <body>
            <?php require_once 'view/page/menu.php'; ?>
            <div class="container-fluid">                    

                <div class="row">
                    <?php for ($i = 1; $i <= 4; $i++) { ?>
                        <div class="col-lg-3 col-md-6">
                            <?php
                            getDiv("primary", "Vendido", "datos");
                            ?>
                        </div>
                    <?php } ?>                     
                </div>
            </div>
        </body>    
    </html>
    <?php
}
?>