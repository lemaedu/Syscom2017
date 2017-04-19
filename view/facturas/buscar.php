<?php
require_once '../../model/productos/MProducto.php';
require_once '../../view/page/FormHorizontal.php';

$buscar = $_POST['b'];

if (!empty($buscar) and strlen($buscar)>4) {

    $obj = new M_Producto();
    ?>
    
        
        <table id="tabla1" class="table table-bordered">            
                <tr class="success">   
                    <?php
                    $array = array("40%", "10%", "10%");
                    $cabecera = array('PRODUCTO', 'P. UNIT', 'DISPONIBLE');
                    $numCampos = count($cabecera);
                    if ($cabecera != NULL) {
                        $i = 0;
                        //---------------------cabecera de la tabla-----------
                        for ($i = 0; $i < count($cabecera); $i++) {
                            echo '<td width="' . $array[$i] . '"><center><strong>' . strtoupper($cabecera[$i]) . '</strong></center></td>';
                        }
                        echo "<td width='10%'><center></center></td>";
                    }
                    ?>                                    
                </tr>            
            <?php            
            $obj->__SET('nombres', $buscar);
//            $obj->setNombres($buscar);

            $datos = $obj->search_productos_disponibles_venta();

            if ($datos != NULL) {
                foreach ($datos as $fila) {
                    ?>                          
                    <tr>
                        <td> <?php echo $fila[1] ?></td>                                                        
                        <td><?php echo $fila[3] ?></td>
                        <td><?php echo $fila[4] ?></td>                                                        
                        <td>                                                        
                            <form method="POST" id="">
                                <input type="hidden" name="id_producto" value="<?php echo $fila[7] ?>">
                                <input type="hidden" name="cantidad" value="1">
                                <input type="hidden" name="valor_venta" value="<?php echo $fila[3] ?>">
                                <input type="hidden" name="id_compra" value="<?php echo $fila[0] ?>">
                                <button type="submit" class="btn btn-xs btn-success" name="btn_agregar_factura" id="btn_agregar_factura" value="<?php echo $fila[0] ?>">OK</button>
                            </form>
                        </td>
                    </tr>                       
                    <?php
                }
            }
            ?>
        </table>
    <?php
}
