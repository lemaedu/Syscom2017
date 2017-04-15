<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/actores/Clientes.php';

class
C_Cliente {

    //put your code here
    public function crear() {

        try {
            $nCliente = new Clientes();
            $nCliente->setNombre($_POST["nombres"]);
            $nCliente->setCedula($_POST["cedula"]);
            $nCliente->setCorreo($_POST["correo"]);
            $nCliente->setTelefono($_POST["telefono"]);
            $nCliente->setDireccion($_POST["direccion"]);

            if ($nCliente->create()) {
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
            $nCliente = new Clientes();
            $nCliente->setId_cliente($_POST["id"]);
            $nCliente->setCedula($_POST["cedula"]);
            $nCliente->setNombre($_POST["nombres"]);
            $nCliente->setTelefono($_POST["telefono"]);
            $nCliente->setCorreo($_POST["correo"]);
            $nCliente->setDireccion($_POST["direccion"]);            

            if ($nCliente->update()) {
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
            $nObj_control = new Clientes();
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

    public function buscar() {
        $nObj = new Clientes();
        $resultado = NULL;
        if (isset($_SESSION['cliente'])) {
            $nObj->setCedula($_SESSION['cliente']);
            $resultado = $nObj->search1();
        }
        if (isset($_POST["buscar"]) and ! empty($_POST["buscar"])) {
            $nObj->setId_cliente($_POST['buscar']);
            $resultado = $nObj->search();
        }
        return $resultado;
    }

    public function buscar_cliente() {
        $nObj = new Clientes();
        $nObj->setId_cliente($_POST['buscar']);

        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function eliminar() {
        try {
            $nCliente = new Clientes();
            $nCliente->setId_cliente($_POST["id"]);
            if ($nCliente->delete()) {
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
        $nObj_control = new Clientes();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
