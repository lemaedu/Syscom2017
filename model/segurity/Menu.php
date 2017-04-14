<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author SYSCOM
 */
require_once 'model/ConexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class Menu {

//put your code here

    var $id_menu;
    var $_id_grupo;
    var $opcion;
    var $contenido;
    var $orden;
    var $estado;
    
    protected $nombre_tabla = "tb_menu";

    function __construct() {
        
    }

    function getId_menu() {
        return $this->id_menu;
    }

    function get_id_grupo() {
        return $this->_id_grupo;
    }

    function getOpcion() {
        return $this->opcion;
    }

    function getContenido() {
        return $this->contenido;
    }

    function getOrden() {
        return $this->orden;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_menu($id_menu) {
        $this->id_menu = $id_menu;
    }

    function set_id_grupo($_id_grupo) {
        $this->_id_grupo = $_id_grupo;
    }

    function setOpcion($opcion) {
        $this->opcion = $opcion;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function create() {
        $conexion = new MysqlPDO();
        if ($conexion) {
            try {
                $sql = "call sp_create_grupos('$this->grupo','$this->imagen')";
                $stm = $conexion->prepare($sql);
                if ($stm->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        }
    }



    public function CamposTabla() {
        return getCamposTabla($this->nombre_tabla);
    }

    public function retrive() {
        return getDatosTabla($this->nombre_tabla);
    }

    public function UpdateEstado() {
        $sp = "sp_update_estado_menu";
        $valor=  "$this->id_menu";
        return updateEstado($sp, $valor);
    }

}
