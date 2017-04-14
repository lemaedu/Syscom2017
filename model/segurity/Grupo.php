<?php

require 'model/conexDB/ConexPDO.php';
// Funciones Genericas
include_once 'model/generico/Funciones.php';

class Grupo {

    var $id_grupo;
    var $grupo;
    var $imagen;
    var $estado;
    /* ------- */
    protected $tabla = "tb_grupos";

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        return $this->$k = $v;
    }

    function __construct() {
        
    }

    function getId_grupo() {
        return $this->id_grupo;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_grupo($id_grupo) {
        $this->id_grupo = $id_grupo;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function create() {
        $conexion = new ConexPDO();
        if ($conexion) {
            try {
                $sql = "call pa_crear_grupos('$this->grupo','$this->imagen')";
                $stm = $conexion->query($sql);
                if ($stm) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        }
    }

    public function update() {
        $conexion = new MysqlPDO();
        if ($conexion) {
            try {
                $sql = "call pa_actualizar_grupos('$this->id_grupo','$this->grupo','$this->imagen')";
                $stm = $conexion->prepare($sql);
                if ($stm) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        }
    }

    public function search() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_grupos
                    WHERE descripcion LIKE '%$this->grupo%'";
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

    public function camposTabla() {
        return getCamposTabla($this->tabla);
    }

    public function datosTabla() {
        return getDatosTabla($this->tabla);
    }

    public function updateEstado() {
        return execute_pa("pa_actualizar_estado_grupos", $this->id_grupo);
    }

    public function deleteDato() {
        return execute_pa("pa_eliminar_grupos", $this->id_grupo);
    }

}
