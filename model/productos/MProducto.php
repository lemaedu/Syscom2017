<?php

require_once '../../model/conexDB/ConexPDO.php';

class M_Producto {

    //put your code here
    var $id_producto;
    var $codigo_barras;
    var $_id_categoria;
    var $_id_marca;
    var $nombres;
    var $imagen;
    var $descripcion;
    var $estado;
      
    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        return $this->$k = $v;
    }

    function __construct() {
        
    }

    public function camposTabla() {
        include_once 'modelo/Funciones.php';
        $tabla = "tb_categorias";
        return getCamposTabla($tabla);
    }

    public function search_productos_disponibles_venta() {
        $conexion = new ConexPDO();
        if ($conexion) {
            try {                
                $dato = $this->nombres;
                $sql = "SELECT id_compras,producto,codigo_barras, valor_venta,stok, fecha_compra,id_factura,id_producto
                    FROM v_productos_disponibles_venta
                    WHERE producto LIKE '%$dato%' or codigo_barras LIKE'%$dato%'";

                $resultado = $conexion->query($sql);                
                return $resultado;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            return false;
        }
    }

}
