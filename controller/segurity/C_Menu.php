<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Menu
 *
 * @author SYSCOM
 */
require_once 'model/segurity/Menu.php';

class C_Menu {

    //put your code here
    public function listar() {
        try {
            $nObj_control = new Menu();
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

    public function getCampos() {
        $nObj_control = new Menu();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

    function cambiarestado() {
        try {
            $nObj = new Menu();
            $nObj->setId_menu($_POST['btnEstado']);

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

    public function actualizar() {
        try {
            $nObj = new Menu();
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

}
