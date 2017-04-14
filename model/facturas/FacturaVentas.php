<?php

include_once 'modelo/ConexDB/conexionMYSQL.php';

class FacturaVentas {

    //put your code here

    var $id_factura;
    var $_id_cliente;
    var $_id_empleado;
    var $fecha_venta;
    var $modificado;
    var $estado;



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

    public function create_factura_ventas() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_factura_ventas('$this->_id_cliente','$this->_id_empleado')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function retriveFacturaAcctiva() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_facturas_ventas_activas WHERE _id_empleado='$this->_id_empleado' and estado=1";

            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);

            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $listaR[] = $lista;
                }
                return $listaR;
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function retriveFacturaNumero() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_facturas_ventas_activas WHERE id_factura='$this->id_factura'";

            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);

            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $listaR[] = $lista;
                }
                return $listaR;
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function closeFacturaAcctivaVentas() {
        $conex = new conexionMYSQL();

        if ($conex->conectar()) {
            $sql = "call pa_cerrar_factura_ventas('$this->id_factura','$this->_id_empleado','$this->estado')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function retriveListaFacturaVentas() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_lista_factura_ventas where id_empleado='$this->_id_empleado' and estado<>'3' ";
            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);
            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $listaR[] = $lista;
                }
                return $listaR;
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function retriveHistorialFacturaVentas() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_lista_factura_ventas where id_empleado='$this->_id_empleado' and CAST(fecha_venta AS DATE) = '$this->fecha_venta'";
            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);
            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $listaR[] = $lista;
                }
                return $listaR;
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function retrive_total_venta_por_factura() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select id_factura,total,descuento FROM v_lista_factura_ventas where id_factura='$this->id_factura'";
            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);
            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $listaR[] = $lista;
                }
                return $listaR;
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function updateEstadoFactura() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "call pa_actualizar_estado_factura_ventas('$this->id_factura','$this->estado')";
                if (!mysql_query($sql)) {
                    echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
                }
                $conex->desconectar();
                return true;
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

}
