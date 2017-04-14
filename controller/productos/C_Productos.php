<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'modelo/productos/Productos.php';

class
C_Productos {

    //put your code here
    public function crear() {

        try {
            $nObj = new Productos();
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
            $nObj = new Productos();
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
            $nObj_control = new Productos();
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

            $nObj = new Productos();
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

        $nObj = new Productos();
        $nObj->setDescripcion($_POST["buscar_producto"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function buscar_productos_pf() {

        $nObj = new Productos();
        $nObj->setDescripcion($_POST["buscar_producto"]);
        if ($datos=$nObj->search_productos_fac()) {
            return $datos;
        } else {
            return false;
        }
    }

    public function buscar_productos_disponibles() {

        $nObj = new Productos();
        $nObj->setDescripcion($_POST["buscar_producto"]);
        if ($datos = $nObj->search_productos_disponibles_venta()) {
            return $datos;
        } else {
            return false;
        }
    }

    public function buscar_productos_disponibles_por_codBarr() {

        $nObj = new Productos();
        $nObj->setId_producto($_POST["codigo_barras"]);
        if ($datos = $nObj->search_productos_disponibles_venta1()) {
            return $datos;
        } else {
            return false;
        }
    }

}
