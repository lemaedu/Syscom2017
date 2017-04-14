<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/productos/Categoria.php';

class C_Categoria {

    //put your code here
    public function crear() {

        try {
            $nObj = new Categoria();
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setDescripcion($_POST["descripcion"]);            
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
            $nObj = new Categoria();
            $nObj->setId_categoria($_POST["id"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setDescripcion($_POST["descripcion"]);
//            $nObj->setEstado($_POST["estado"]);

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
            $nObj_control = new Categoria();
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

            $nObj = new Categoria();
            $nObj->setId_categoria($_POST["id"]);
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

    function buscar() {
        $nObj = new Categoria();
        $nObj->setNombres($_POST["buscar"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function getCampos() {
        $nObj_control = new Categoria();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
