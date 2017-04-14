<?php

include_once 'modelo/ConexDB/conexionMYSQL.php';

class FacturaDetalleCompras {

    //put your code here
    var $id_compras;
    var $_id_factura;
    var $_id_producto;
    var $cantidad;
    var $valor_compra;
    var $stok;
    var $descuento;
    var $valor_venta;
    var $estado;
    //----------CAMPOS PARA CONSULTAS 
    var $id_empleado;

    /* CAMPOS DE LA TABLA */

    function __construct() {
        
    }

    function getId_empleado() {
        return $this->id_empleado;
    }

    function setId_empleado($id_empleado) {
        $this->id_empleado = $id_empleado;
    }

    function getId_compras() {
        return $this->id_compras;
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

    function getValor_compra() {
        return $this->valor_compra;
    }

    function getStok() {
        return $this->stok;
    }

    function getDescuento() {
        return $this->descuento;
    }

    function getValor_venta() {
        return $this->valor_venta;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_compras($id_compras) {
        $this->id_compras = $id_compras;
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

    function setValor_compra($valor_compra) {
        $this->valor_compra = $valor_compra;
    }

    function setStok($stok) {
        $this->stok = $stok;
    }

    function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    function setValor_venta($valor_venta) {
        $this->valor_venta = $valor_venta;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function f_compra_real() {
        return (($this->valor_compra) - ($this->valor_compra * $this->descuento));
    }

    public function f_precio_venta() {
        return (($this->f_compra_real()) + ($this->f_compra_real() * 0.3));
    }

    public function create_detalle_factura() {

        $compra_real = $this->f_compra_real();
        $venta = $this->f_precio_venta();

        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $valor_r = round($compra_real, 2);

            $sql = "call pa_crear_factura_detalle_compras('$this->_id_factura', '$this->_id_producto','$this->cantidad',
                            '$this->valor_compra','$compra_real','$this->stok','$this->descuento','$venta')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function actualizar_detalle_factura() {

        $compra_real = number_format($this->f_compra_real(), 4, '.', ',');
        $val_com = number_format($this->valor_compra, 4, '.', ',');
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_actualizar_factura_detalle_compras('$this->id_compras','$this->cantidad',
                            '$val_com','$compra_real','$this->stok','$this->descuento','$this->valor_venta')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function actualizar_detalle_factura_stok() {

        $compra_real = number_format($this->f_compra_real(), 4, '.', ',');
        $val_com = number_format($this->valor_compra, 4, '.', ',');
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_actualizar_stok('$this->id_compras','$this->stok','$this->_id_factura')";
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
            $sql = "call pa_eliminar_factura_detalle_compras('$this->id_compras')";
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
            $sql = "select * FROM v_factura_compras_abiertas";

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

    function retrive_detalle_factura_compras() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_detalle_factura_compras WHERE _id_empleado='$this->id_empleado' and estado='1' and id_factura='$this->_id_factura'";
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

    function retrive_detalle_factura_compras_stok() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {

            $sql = "select * FROM v_detalle_factura_compras_stok";
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

    function retrive_detalle_factura_compras_total() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {

            $sql = "select sum(valor_real_compra*cantidad) as total FROM v_detalle_factura_compras WHERE  id_factura='$this->_id_factura'";

            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);

            if (($result) && ($num_col > 0)) {
                return $fila = mysql_fetch_array($result, MYSQL_ASSOC);
            } else {
                return false;
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

}
