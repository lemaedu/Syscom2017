<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/segurity/Opciones.php';

class C_Opciones {

    //put your code here
    public function crear() {

        try {
            $nObj = new Opciones();
            $nObj->setDescripcion($_POST["descripcion"]);
            $nObj->setCantidad($_POST["cantidad"]);
            $nObj->setValor_compra($_POST["precio_compra"]);
            $nObj->setDescuento($_POST["descuento"]);
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
            $nObj = new Opciones();
            $nObj->setId_producto($_POST["id"]);            
            $nObj->setDescripcion($_POST["descripcion"]);
            $nObj->setStok($_POST["stok"]);
            $nObj->setPrecio_venta($_POST["precio_venta"]);            
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
            $nObj_control = new Opciones();
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

            $nObj = new Opciones();
            $nObj->setId_producto($_POST["id"]);
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

        $nObj = new Opciones();
        $nObj->setDescripcion($_POST["buscar"]);        
        if ($nObj->search()) {
            return  $nObj->search();
        } else {
            return false;
        }
    }

}
