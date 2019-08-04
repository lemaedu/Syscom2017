<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marca
 *
 * @author SYSCOM
 */
require_once 'model/ConexDB/ConexPDO.php';

class Marca {

    //put your code here
    var $id_marca;
    var $nombre;
    var $descripcion;
    var $estado;
/* ---------------- */
    private $attrib = array();
    protected $tabla = "tb_marca";

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

    /* ---------------METODOS CRUD-------------- */
    /* CREATE */

    function create() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_marca('$this->nombre','$this->descripcion')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    /* READ */

    function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_marcas ORDER BY nombre ASC";
            $result = $conex->query($sql);
                        
            if ($result) {
                return $result;
            } else {
                return false;
            }
            mysql_free_result($result);
            $conex->desconectar();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    /* UPDATE */

    function update() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "UPDATE tb_marcas SET nombre='$this->nombre', descripcion='$this->descripcion'
                         WHERE id_marca='$this->id_marca'";
                $result = mysql_query($sql);
                if ($result > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function updateEstado() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "call pa_actualizar_estado_marca('$this->id_marca')";
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

    /* DELETE */

    function delete() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "DELETE FROM tb_marcas WHERE id_marca='$this->id_marca'";
                if (mysql_query($sql) > 0) {//Si es distinto de 1 ; si no se ejecuta                
                    return true;
                } else {
                    return false;
                }
                $conex->desconectar();
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    /* ---------------OTROS METOS---------- */

    function search() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "SELECT * FROM tb_marcas
                    WHERE nombre LIKE '%$this->nombre%'";
            $result = mysql_query($sql);
            $numero_filas = mysql_num_rows($result);
            if (($result) && ($numero_filas > 0)) {
                while ($lista_temporal = mysql_fetch_row($result)) {
                    $lista_resultados[] = $lista_temporal;
                }
                return $lista_resultados;
            } else {
                return false;
            }
            mysql_free_result($result);
            $conex->desconectar();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    function getCamposTabla() {
        $conex = new ConexPDO();
        $tabla = "tb_marcas";
        $sql = "SHOW COLUMNS FROM $tabla";
        return $conex->query($sql);
    }

}
