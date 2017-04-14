<?php

require_once 'model/conexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class Categoria {

    var $id_categoria;
    var $nombres;
    var $descripcion;
    var $registrado;
    var $modificado;
    var $estado;
    /* ---------------- */
    private $attrib = array();
    protected $tabla = "tb_categorias";

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
            $sql = "call pa_crear_categoria('" . $this->getNombres() . "','" . $this->getDescripcion() . "')";
            if (!$conex->query($sql)) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function update() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "call pa_actualizar_categoria('" . $this->getId_categoria() . "','" . $this->getNombres() . "','" . $this->getDescripcion() . "')";
            if (!$conex->query($sql)) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function delete() {
        return execute_pa("pa_eliminar_categoria", $this->getId_categoria());
    }

    public function retrive() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "SELECT * FROM $this->tabla ORDER BY nombres ASC";
            $stm = $conexion->query($sql);
            if ($stm) {
                return $stm;
            } else {
                return false;
            }
        }
    }

    function search() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla
                    WHERE nombres LIKE '%$this->nombres%'";
            $result = $conex->query($sql);
            if (!$result) {
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
