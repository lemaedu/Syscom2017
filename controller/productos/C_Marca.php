<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Marca
 *
 * @author SYSCOM
 */
require_once 'model/productos/Marca.php';

class C_Marca {

    //put your code here
    function crear() {
        try {
            $nObj = new Marca();
            $nObj->setNombre($_POST["nombre"]);
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

    function actualizar() {
        try {
            $nObj = new Marca();
            $nObj->setId_marca($_POST["id"]);
            $nObj->setNombre($_POST["nombre"]);
            $nObj->setDescripcion($_POST["descripcion"]);
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

    function eliminar() {
        try {

            $nObj = new Marca();
            $nObj->setId_marca($_POST["id"]);
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

    function listar() {
        try {
            $nObj_control = new Marca();
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

    function buscar() {
        $nObj = new Marca();
        $nObj->setNombre($_POST["buscar"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    function getCampos() {
        $nObj_control = new Marca();
        if ($lista_control = $nObj_control->getCamposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }
      function cambiarestado() {
        try {            
            $nObj = new Marca();
            $nObj->setId_marca($_POST['btnEstado']);                        

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

}
