<?php

require_once ('model/ConexDB/ConexPDO.php');

class FacturaDetalleVentas {

    //put your code here
    var $id_venta;
    var $_id_factura;
    var $_id_producto;
    var $cantidad;
    var $precio_venta;
    var $descuento;
    var $estado;
    //----------CAMPOS PARA CONSULTAS 
    var $id_empleado;
    var $_id_transaccion_venta;

    /* CAMPOS DE LA TABLA */
    private $attrib = array();
    protected $tabla = "tb_categorias";

    function __construct() {
        
    }

    /*     * ************************************************ */

    function getId_venta() {
        return $this->id_venta;
    }

    function get_id_factura() {
        return $this->_id_factura;
    }

    function get_id_producto() {
        return $this->_id_producto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio_venta() {
        return $this->precio_venta;
    }

    function getDescuento() {
        return $this->descuento;
    }

    function getEstado() {
        return $this->estado;
    }

    function getId_empleado() {
        return $this->id_empleado;
    }

    function get_id_transaccion_venta() {
        return $this->_id_transaccion_venta;
    }

    function setId_venta($id_venta) {
        $this->id_venta = $id_venta;
    }

    function set_id_factura($_id_factura) {
        $this->_id_factura = $_id_factura;
    }

    function set_id_producto($_id_producto) {
        $this->_id_producto = $_id_producto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setPrecio_venta($precio_venta) {
        $this->precio_venta = $precio_venta;
    }

    function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setId_empleado($id_empleado) {
        $this->id_empleado = $id_empleado;
    }

    function set_id_transaccion_venta($_id_transaccion_venta) {
        $this->_id_transaccion_venta = $_id_transaccion_venta;
    }

    /* ---------------------------------------------- */

    public function create_detalle_factura() {

        $conex = new conexionMYSQL();
        if ($conex->conectar()) {

            $sql = "call pa_crear_factura_detalle_ventas('$this->_id_factura', '$this->_id_producto','$this->cantidad',
                            '$this->precio_venta')";
            $sql1 = "call pa_actualizar_stok('$this->_id_transaccion_venta','$this->cantidad')";

            if ((!mysql_query($sql)) and ( !mysql_query($sql1))) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function actualizar_detalle_factura_ventas() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_actualizar_factura_detalle_ventas('$this->id_venta','$this->_id_factura',
                            '$this->cantidad','$this->precio_venta','$this->descuento')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function eliminar_registro_detalle_factura() {

        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_eliminar_factura_detalle_ventas('$this->id_venta','$this->_id_factura')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    
    public function retriveFacturaAcctiva() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select * FROM v_factura_compras_abiertas";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    public function retrive_detalle_factura_compras() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select * FROM v_detalle_facrura_compras WHERE _id_empleado='$this->id_empleado'";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    public function retrive_detalle_factura_ventas_por_numero() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select * FROM v_detalle_factura_venta WHERE _id_empleado='$this->id_empleado' and id_factura='$this->_id_factura'";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    public function retrive_detalle_factura_ventas() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select * FROM v_detalle_factura_venta WHERE _id_empleado='$this->id_empleado' and estado='1'";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    public function retrive_detalle_factura_ventas_total() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select  sum(precio_venta*cantidad - precio_venta*cantidad*descuento) as total FROM v_detalle_factura_venta WHERE _id_empleado='$this->id_empleado' and estado='1'";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    public function retrive_detalle_factura_ventas_descuento() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "select  sum(precio_venta*cantidad) as descuento FROM v_detalle_factura_venta WHERE _id_empleado='$this->id_empleado' and estado='1'";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

}
