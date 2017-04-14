<?php

require_once 'model/conexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class FacturaCompras {

    //put your code here

    var $_ruc;
    var $id_factura;
    var $_id_empleado;
    var $fecha_compra;
    var $estado;
    private $attrib = array();
    protected $tabla = "tb_factura_compras";


    /* CAMPOS DE LA TABLA */
    public $array = array("RUC", "NUMERO DE FACTURA", "EMPLEADO", "FECHA DE COMPRA", "ESRADO");

    function __construct() {
        
    }

    function get_ruc() {
        return $this->_ruc;
    }

    function getId_factura() {
        return $this->id_factura;
    }

    function get_id_empleado() {
        return $this->_id_empleado;
    }

    function getFecha_compra() {
        return $this->fecha_compra;
    }

    function getEstado() {
        return $this->estado;
    }

    function getArray() {
        return $this->array;
    }

    function set_ruc($_ruc) {
        $this->_ruc = $_ruc;
    }

    function setId_factura($id_factura) {
        $this->id_factura = $id_factura;
    }

    function set_id_empleado($_id_empleado) {
        $this->_id_empleado = $_id_empleado;
    }

    function setFecha_compra($fecha_compra) {
        $this->fecha_compra = $fecha_compra;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setArray($array) {
        $this->array = $array;
    }

    public function create_factura_compras() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_factura_compras('$this->_ruc','$this->id_factura',
                            '$this->_id_empleado','$this->fecha_compra')";
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
            $sql = "select * FROM v_lista_factura_compras WHERE id_empleado='$this->_id_empleado' and estado='1'";

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

    public function closeFacturaAcctiva() {
        $conex = new conexionMYSQL();

        if ($conex->conectar()) {
            $sql = "call pa_cerrar_factura_compras('$this->id_factura','$this->estado')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function r_listarFacturaCompras() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "select * FROM v_lista_factura_compras";
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

}
