<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/segurity/Grupo.php';

class
C_Grupo {

    //put your code here
    public function crear() {

        try {
            $nObj = new Grupo();
            $nObj->setGrupo($_POST["grupo"]);
            $nObj->setImagen($_POST["imagen"]);
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
            $nObj = new Grupo();
            $nObj->setId_grupo($_POST["id"]);
            $nObj->setGrupo($_POST["grupo"]);
            $nObj->setImagen($_POST["imagen"]);
            //$nObj->setEstado($_POST["estado"]);

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
            $nObj_control = new Grupo();
            if ($lista_control = $nObj_control->datosTabla()) {
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

            $nObj = new Grupo();
            $nObj->setId_grupo($_POST["id"]);
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

        $nObj = new Grupo();
        $nObj->setGrupo($_POST["buscar"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    function cambiarEstado() {
        try {
            $nObj = new Grupo();
            $nObj->setId_grupo($_POST['btnEstado']);
            $nObj->setEstado($_POST['btnEstado']);
            if ($nObj->updateEstado()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function getCampos() {
        $nObj_control = new Grupo();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
