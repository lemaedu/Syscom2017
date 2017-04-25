<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/actores/Persona.php';

class C_Empleado {

    //put your code here
    public function recogerDatos() {
        
    }

    public function crear() {

        try {
            $nObj = new Empleado();
            $nObj->setCedula($_POST["id_empleado"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setApellidos($_POST["apellidos"]);
            $nObj->setNacimiento($_POST["nacimiento"]);
            $nObj->setSexo($_POST["sexo"]);
            $nObj->setCorreo($_POST["correo"]);
            $nObj->setNacionalidad($_POST["nacionalidad"]);
            $nObj->setTelefono($_POST["telefono"]);
            $nObj->setDireccion($_POST["direccion"]);
            $nObj->setFoto($_POST["foto"]);
            $nObj->setEstado($_POST["estado"]);
            if ($nObj->create()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function crear_usario_factura() {

        try {
            $nObj = new Clientes();
            $nObj->setCedula($_SESSION['cliente']);
            $nObj->setId_cliente($_SESSION['s_id_usuario']);
            if ($nObj->create_usuario_factura()) {
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
            $nObj = new Empleado();
            $nObj->setCedula($_POST["cedula"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setApellidos($_POST["apellidos"]);
            $nObj->setNacimiento($_POST["f_nac"]);
            $nObj->setSexo($_POST["sexo"]);
            $nObj->setCorreo($_POST["correo"]);
            $nObj->setNacionalidad($_POST["nacionalidad"]);
            $nObj->setTelefono($_POST["telefono"]);
            $nObj->setDireccion($_POST["direccion"]);
//            $nObj->setFoto($_POST["foto"]);
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

    function listar() {
        try {
            $nObj_control = new Empleado();
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

    
       public function buscarEmpleado() {
        $nObj = new Empleado();
        $resultado = NULL;
        if (isset($_SESSION['s_id_usuario'])) {
            $nObj->setCedula($_SESSION['s_id_usuario']);
            $resultado = $nObj->search1();
        }
        if (isset($_POST["buscar"]) and ! empty($_POST["buscar"])) {
            $nObj->setId_cliente($_POST['buscar']);
            $resultado = $nObj->search();
        }
        return $resultado;
    }
    
    public function buscar() {
        $nObj = new Empleado();
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

    public function eliminar() {

        try {

            $nObj = new Empleado();
            $nObj->setCedula($_POST["id"]);
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

    function getCampos() {
        $nObj_control = new Empleado();
        if ($lista_control = $nObj_control->getCamposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
