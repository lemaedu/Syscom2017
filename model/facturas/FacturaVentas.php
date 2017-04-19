<?php

require_once ('model/ConexDB/ConexPDO.php');

class FacturaVentas {

    //put your code here

    var $id_factura;
    var $_id_cliente;
    var $_id_empleado;
    var $fecha_venta;
    var $modificado;
    var $estado;
    private $attrib = array();
    protected $tabla = "tb_factura_ventas";


    /* CAMPOS DE LA TABLA */
    public $array = array("RUC", "NUMERO DE FACTURA", "EMPLEADO", "FECHA DE COMPRA", "ESRADO");

    function __construct() {
        
    }

    /* --------------------------------------------------------------------- */

    function getId_factura() {
        return $this->id_factura;
    }

    function get_id_cliente() {
        return $this->_id_cliente;
    }

    function get_id_empleado() {
        return $this->_id_empleado;
    }

    function getFecha_venta() {
        return $this->fecha_venta;
    }

    function getModificado() {
        return $this->modificado;
    }

    function getEstado() {
        return $this->estado;
    }

    function getArray() {
        return $this->array;
    }

    function setId_factura($id_factura) {
        $this->id_factura = $id_factura;
    }

    function set_id_cliente($_id_cliente) {
        $this->_id_cliente = $_id_cliente;
    }

    function set_id_empleado($_id_empleado) {
        $this->_id_empleado = $_id_empleado;
    }

    function setFecha_venta($fecha_venta) {
        $this->fecha_venta = $fecha_venta;
    }

    function setModificado($modificado) {
        $this->modificado = $modificado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setArray($array) {
        $this->array = $array;
    }

    /* --------------------------------------------------------------------- */

    function create_factura_ventas() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_crear_factura_ventas('$this->_id_cliente','$this->_id_empleado')";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } 
    }

    function retriveFacturaAcctiva() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_facturas_ventas_activas WHERE _id_empleado='$this->_id_empleado' and estado=1";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function retriveFacturaNumero() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_facturas_ventas_activas WHERE id_factura='$this->id_factura'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function closeFacturaAcctivaVentas() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_cerrar_factura_ventas('$this->id_factura','$this->_id_empleado','$this->estado')";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function retriveListaFacturaVentas() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_lista_factura_ventas where id_empleado='$this->_id_empleado' and estado<>'3' ";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function retriveHistorialFacturaVentas() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_lista_factura_ventas where id_empleado='$this->_id_empleado' and CAST(fecha_venta AS DATE) = '$this->fecha_venta'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function retrive_total_venta_por_factura() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select id_factura,total,descuento FROM v_lista_factura_ventas where id_factura='$this->id_factura'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    function updateEstadoFactura() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_actualizar_estado_factura_ventas('$this->id_factura','$this->estado')";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

}
