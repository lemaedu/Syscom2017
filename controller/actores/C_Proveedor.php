<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/actores/Proveedor.php';
//require_once 'model/facturas/FacturaCompras.php';

class
C_Proveedor {

    //put your code here
    public function crear() {

        try {
            $nObj = new Proveedor();
            $nObj->setRuc($_POST["ruc"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setCorreo($_POST["correo"]);
            $nObj->setTelefono($_POST["telefono"]);
            $nObj->setDireccion($_POST["direccion"]);

            if ($nObj->create()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function crear_proveedor_factura() {

        try {
            $nObj = new FacturaCompras();
            $nObj->set_id_cliente($_POST['btnFact']);
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            $nObj->setId_factura($_POST['factura']);
            $nObj->setFecha_compra($_POST['fecha']);

            if ($nObj->create_factura()) {
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
            $nObj = new Proveedor();
            $nObj->setRuc($_POST["id"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setTelefono($_POST["telefono"]);
            $nObj->setCorreo($_POST["correo"]);
            $nObj->setDireccion($_POST["direccion"]);            

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
            $nObj_control = new Proveedor();
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
        $nObj_control = new Proveedor();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

    public function eliminar() {
        try {

            $nObj = new Proveedor();
            $nObj->setRuc($_POST["id"]);           
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

    public function buscar($buscar) {
        $nObj = new Proveedor();
        $nObj->setId_proveedor($buscar);

        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function FacturaActivada() {
        try {

            $nObj = new FacturaCompras();
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            if ($nObj->retriveFacturaAcctiva()) {
                return $nObj->retriveFacturaAcctiva();
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }
    
     public function cerrarFacturaActivada() {
        try {
            $nObj = new FacturaCompras();            
            $nObj->setId_factura($_POST['id_factura_cerrar']);            
            $nObj->setEstado(0);
            if ($nObj->closeFacturaAcctiva()) {
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
