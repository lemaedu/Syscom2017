<?php
//require_once 'modelo/Clientes.php';
//require_once 'modelo/conexionMYSQL.php';

$buscar = '';
if (isset($_POST['buscar'])) {
    $dato = $_POST['buscar'];
    $nObj = new Clientes();
    $nObj->setId_cliente($dato);
    if (!$result = $nObj->search()) {
        foreach ($result as $fila) {
            ?>
            <div class=" panel panel-primary">
                <div class="panel-heading">USUARIO</div>
                <div class="panel-body">
                    <div class="col-md-8">
                        <strong>CLIENTE</strong><br>
                        <input  class="form-control" type="text" name="cantidad" autocomplete="off" value="<?php echo $fila['nombres']; ?>">
                        <strong>CEDULA RUC</strong>
                        <input  class="form-control" type="text" name="cantidad" autocomplete="off" value="<?php echo $fila['cedula']; ?>">
                        <strong>DIRECCION</strong>
                        <input  class="form-control" type="text" name="cantidad" autocomplete="off" value="<?php echo $fila['direccion']; ?>" ><br>
                    </div>

                    <div class="col-md-4">
                        <strong>FECHA</strong><br>
                        <input  class="form-control" type="text" name="cantidad" autocomplete="off" value="<?php echo date(' jS  F Y h:i:s A'); ?>" >
                        <strong>TELEFONO</strong>
                        <input  class="form-control" type="text" name="cantidad" autocomplete="off" value="<?php echo $fila['telefono']; ?>">

                    </div>
                </div>
            </div>   
            <?php
        }
    }
}
    