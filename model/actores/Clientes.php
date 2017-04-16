<?php

require_once 'model/ConexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class Clientes {

    var $id_cliente;
    var $nombre;
    var $cedula;
    var $correo;
    var $telefono;
    var $direccion;
    var $estado;

    /* ---------------- */
    private $attrib = array();
    protected $tabla = "tb_clientes";

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
            $sql = "call pa_crear_cliente(" . $this->getNombre() . "," . $this->getCedula() . ",
                            " . $this->getCorreo() . "," . $this->getTelefono() . "," . $this->getDireccion() . ")";
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

    public function update() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_actualizar_cliente(" . $this->getId_cliente() . ", " . $this->getNombre() . "," . $this->getCedula() . "',
                        " . $this->getCorreo() . "," . $this->getTelefono() . "," . $this->getDireccion() . ")";
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

    
    public function delete(){
        return execute_pa("pa_eliminar_cliente", $this->getId_cliente());
    }
     

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla ";
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

    public function search() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla
                    WHERE (cedula LIKE '%$this->id_cliente%') OR (nombres  LIKE '%$this->id_cliente%')";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } 
    }

    public function search1() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla
                    WHERE (id_cliente ='$this->cedula')";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } 
    }

    public function camposTabla() {
        return getCamposTabla($this->tabla);
    }

}
