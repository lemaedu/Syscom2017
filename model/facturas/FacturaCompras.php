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
    /* ------------ */
    private $attrib = array();
    protected $tabla = "tb_factura_compras";


    /* CAMPOS DE LA TABLA */
    public $array = array("RUC", "NUMERO DE FACTURA", "EMPLEADO", "FECHA DE COMPRA", "ESRADO");

    function __construct() {
        
    }

    //Metodo magico utilizado para __set y __get
    public function __call($method, $args) {
        $methodType = substr($method, 0, 3);
        $attribName = strtolower(substr($method, 3));
        $claseName = get_class($this);
        if ($methodType == "set") {
            if (property_exists($claseName, $attribName)) {
                $this->setAttrib($attribName, $args[0]);
            } else {
                echo "No existe el atributo $attribName.";
            }
        }
        if ($methodType == "get") {
            if (property_exists($claseName, $attribName)) {
                return $this->getAttrib($attribName);
            } else {
                echo 'Método no definido <br/>';
            }
        }
    }

    private function setAttrib($attribName, $value) {
        $this->attrib[$attribName] = "$value";
    }

    private function getAttrib($attribName) {
        return $this->attrib[$attribName];
    }

    public function create_factura_compras() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_crear_factura_compras(" . $this->get_ruc() . "," . $this->getId_factura() . "," .
                    $this->get_id_empleado() . "," . $this->getFecha_compra() . ")";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function retriveFacturaAcctiva() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_lista_factura_compras WHERE id_empleado='" . $this->get_id_empleado() . "' and estado='1'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function closeFacturaAcctiva() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_cerrar_factura_compras(" . $this->getId_factura() . "," . $this->getEstad() . ")";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function r_listarFacturaCompras() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "select * FROM v_lista_factura_compras";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

}
