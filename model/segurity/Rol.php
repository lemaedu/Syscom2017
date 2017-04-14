<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Equipo
 *
 * @author Lema
 */
require_once 'model/conexDB/ConexPDO.php';

class Rol {

    //put your code here

    private $id_rol;
    private $rol;
    private $registrado;
    private $modificado;
    private $estado; //A=Activado; X=Desactivado

    public function create() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "INSERT INTO tb_roles(rol,estado)
                    VALUES('$this->rol','A')";

            $result = $conex->query($sql);
            if (!$result) {//Si es distinto de 1 ; si no se ejecuta
                echo 'NO SE PUDO INGRESAR'; //; si no se ejecuta
                return false;
            }
            $conex->CloseConnection();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function update() {
        $conex = new ConexPDO();
        if ($conex) {
            try {
                $sql = "UPDATE tb_roles SET rol='$this->rol',estado='$this->estado'
                         WHERE id_rol='$this->id_rol'";
                $result = $conex->query($sql);
                if ($result) {
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

    public function delete() {
        $conex = new ConexPDO();
        if ($conex) {
            try {
                $sql = "DELETE FROM tb_roles WHERE id_rol='$this->id_rol'";
                if ($conex->query($sql) > 0) {//Si es distinto de 1 ; si no se ejecuta                
                    return true;
                } else {
                    return false;
                }
                $conex->CloseConnection();
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_roles";
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
            $sql = "SELECT * FROM tb_roles
                    WHERE rol LIKE '%$this->rol%'";
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

    public function retrive_all() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_roles where estado='A'";
            $result = $conex->query($sql);

            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        } else {
            return false;
        }
    }

    public function search_rol() {
        $conex = new ConexPDO();
        $sql = "SELECT g.grupo, mn.opcion, mn.contenido
            FROM tb_accesos ac
            JOIN tb_menu mn ON ac._id_menu = mn.id_menu
            JOIN tb_grupos g ON mn._id_grupo = g.id_grupo
            WHERE ac._id_rol = '$this->id_rol' and g.estado='A' and mn.estado='A'
            ORDER BY grupo, mn.orden";
        $datos = $conex->query($sql);
        return $datos;
    }
    
    function __construct() {
        
    }

    public function getId_rol() {
        return $this->id_rol;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getRegistrado() {
        return $this->registrado;
    }

    public function getModificado() {
        return $this->modificado;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId_rol($id_rol) {
        $this->id_rol = $id_rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setRegistrado($registrado) {
        $this->registrado = $registrado;
    }

    public function setModificado($modificado) {
        $this->modificado = $modificado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    function getCamposTabla() {
       include_once 'model/generico/Funciones.php';
        $tabla = "tb_roles";
        return getCamposTabla($tabla);
    }

}
