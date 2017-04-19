<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/productos/Producto.php';

class
C_Producto {

    //put your code here
    public function crear() {

        try {
            $nObj = new Producto();
            $nObj->set_id_categoria($_POST["categoria"]);
            $nObj->set_id_marca($_POST["marca"]);
            $nObj->setCodigo_barras($_POST["codigo_barras"]);
            $nObj->setNombres($_POST["nombre"]);
            $nObj->setDescripcion("");
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
            $nObj = new Producto();

            $nObj->set_id_categoria($_POST["categoria"]);
            $nObj->set_id_marca($_POST["marca"]);
            $nObj->setCodigo_barras($_POST["codigo_barras"]);
            $nObj->setNombres($_POST["nombre"]);
            $nObj->setId_producto($_POST["id"]);
            //$nObj->setImagen($_POST["im"]);            
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
            $nObj_control = new Producto();
            if ($lista_control = $nObj_control->retrive1()) {
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

            $nObj = new Producto();
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

        $nObj = new Producto();
        $nObj->setDescripcion($_POST["buscar_producto"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function buscar_productos_disponibles_por_codBarr() {

        $nObj = new Producto();
        $nObj->setId_producto($_POST["codigo_barras"]);
        if ($datos = $nObj->search_productos_disponibles_venta1()) {
            return $datos;
        } else {
            return false;
        }
    }

    public function buscar_productos_disponibles() {

        $nObj = new Producto();
        $nObj->setDescripcion($_POST["buscar_producto"]);
        if ($datos = $nObj->search_productos_disponibles_venta()) {
            return $datos;
        } else {
            return false;
        }
    }

}
