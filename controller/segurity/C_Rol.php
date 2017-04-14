<?php

require_once 'model/segurity/Rol.php';

class C_Rol {

    public function crear() {

        try {
            $nObj = new Rol();            
            $nObj->setRol($_POST["rol"]);
            //$nObj->setImagen($_POST["imagen"]);
            if ($nObj->create()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function actualizar() {
        try {
            $nObj = new Rol();
            $nObj->setId_rol($_POST["id"]);
            $nObj->setRol($_POST["rol"]);
            //$nObj->setImagen($_POST["imagen"]);
            $nObj->setEstado($_POST["estado"]);

            if ($nObj->update()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function listar() {
        try {
            $nObj_control = new Rol();
            if ($lista_control = $nObj_control->retrive()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function eliminar() {
        try {

            $nObj = new Rol();
            $nObj->setId_rol($_POST["id"]);
            if ($nObj->delete()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function buscar() {

        $nObj = new Rol();
        $nObj->setRol($_POST["buscar"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function _set($i_rol) {

        $nObj_control = new Rol();
        $nObj_control->setId_rol($i_rol);
        if ($lista_control = $nObj_control->search_rol()) {
            return $lista_control;
        } else {
            return false;
        }
    }

    public function c_mostrar_roles() {
        try {
            $nObj_control = new Rol();
            if ($lista_control = $nObj_control->retrive_all()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    function getCampos() {
        $nObj_control = new Rol();
        
        if ($lista_control = $nObj_control->getCamposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
