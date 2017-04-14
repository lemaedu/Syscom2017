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

    function __construct() {
        
    }

    function getId_marca() {
        return $this->id_marca;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_marca($id_marca) {
        $this->id_marca = $id_marca;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
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
