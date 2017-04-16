<?php

require_once 'model/conexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class Proveedor {

    var $id_proveedor;
    var $_id_usario;
    var $ruc;
    var $nombres;
    var $correo;
    var $telefono;
    var $direccion;
    var $estado;
    private $attrib = array();
    protected $tabla = "tb_proveedores";

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

    public function create() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_crear_proveedores(" . $this->getRuc() . "," . $this->getNombres() . ",
                    " . $this->getCorreo() . "," . $this->getTelefono() . "," . $this->getDireccion() . ")";
            $result = $conex->query($sql);
            if (($result)) {
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

    public function update() {
        $conex = new ConexPDO();
        if ($conex) {
            try {
                $sql = "call pa_actualizar_proveedor(" . $this->getRuc() . "," . $this->getNombres() . "," . $this->getCorreo() . "," .
                        $this->getTelefono() . "," . $this->getDireccion() . ")";
                $result = $conex->query($sql);
                if (!$result) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
            $conex->CloseConnection();
        }
    }

    public function delete() {
        echo '' . $this->getRuc();
        return execute_pa("pa_eliminar_proveedor", $this->getRuc());
    }

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla";
            $result = $conex->query($sql);
            if (($result)) {
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

    public function search() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_proveedores                
                   WHERE (ruc LIKE '%" . $this->getId_proveedor() . "%') OR (nombres  LIKE '%" . $this->getId_proveedor() . "%')";
            $result = $conex->query($sql);
            if (($result)) {
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

    public function camposTabla() {
        return getCamposTabla($this->tabla);
    }

}
