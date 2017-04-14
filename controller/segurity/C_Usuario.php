<?php

require_once 'model/segurity/M_Usuario.php';

class C_Usuario {

    public function listar() {
        try {
            $nObj_control = new M_Usuario();
            if ($lista_control = $nObj_control->retrive_all()) {
                return $lista_control;
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
            $nObj = new M_Usuario();
            $estado = $_POST["estado"];
            $id_us_rol = $_POST["id_usuario_rol"];
            $_id_usuario = $_POST["id_usuario"];
            $id_rol = $_POST["rol"];
            if ($nObj->update_usuario_rol($id_us_rol, $id_rol, $_id_usuario, $estado)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    //put your code here
    public function controlDatos() {
        if (isset($_POST['ingreso'])) {
            $id_usuario = $_POST["id_usuario"];
            $passw = $_POST["passw"];
            try {
                $nObj = new M_Usuario();
                $nObj->setId_usuario($id_usuario);
                $nObj->setPassw($passw);
                $nObj->create();
            } catch (Exception $ex) {
                echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
            }

            if ($op != 0) {
                echo " <script type=\"text/javascript\">alert(\"Ingresado correctamente\")</script>";
            } else {
                echo " <script type=\"text/javascript\">alert(\"Intentalo nuevamente\")</script>";
            }
        }
    }

    function quitar($mensaje) {
        $nopermitidos = array("'", '\\', '<', '>', "\"");
        $mensaje = str_replace($nopermitidos, "", $mensaje);
        return $mensaje;
    }

    public function login_controlador() {
        $bandera = false;
        $nObj = new M_Usuario();
        $nObj->setId_usuario($_POST["usuario"]);
        $nObj->setPassw(md5($_POST["passw"]));
        if ($nObj->search_user()) {
            $bandera = true;
        } else {
            $bandera = false;
        }
        return $bandera;
    }

    public function eliminar() {
        try {
            $nObj_control = new M_Usuario;
            if ($lista_control = $nObj_control->retrive_all()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function c_mostrar_usuario() {
        try {
            $nObj_control = new M_Usuario();
            if ($lista_control = $nObj_control->retrive_all()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function cambiar_pssw() {
        if (!empty($_POST['c1']) and ! empty($_POST['c2']) and ! empty($_POST['contra'])) {
            if ($_POST['c1'] == $_POST['c2']) {
                $nObj = new M_Usuario();
                $nObj->setId_usuario($_SESSION['s_id_usuario']);
                $nObj->setPassw(md5($_POST['contra']));
                $nObj->setPassw_new(md5($_POST['c2']));

                if ($nObj->change_passw()) {
                    return true;
                } else {
                    return false;
                };
            } else {
                echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Las dos Contraseña!</strong> Digitadas no soy iguales
					</div>';
            }
        }
    }

    public function getCampos() {
        $nObj_control = new M_Usuario();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

}
