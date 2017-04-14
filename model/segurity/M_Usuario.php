<?php

require_once 'model/conexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';

class M_Usuario {

//put your code here

    private $id_usuario;
    private $passw;
    private $estado;
    private $passw_new;

    /* ------------------------------------------------------------------ */
    private $attrib = array();
    protected $tabla = "tb_usuarios";

    public function search_user() {

        $cnx = new ConexPDO();

        $sql = "SELECT u.id_usuario,passw,u.estado,concat_ws(' ', nombres, apellidos) as fullname,
		r.id_rol, r.rol
                FROM tb_empleados e
                    JOIN tb_usuarios u ON e.id_empleado = u.id_usuario
                    JOIN tb_usuarios_roles ur ON u.id_usuario = ur._id_usuario
                    JOIN tb_roles r ON ur._id_rol = r.id_rol                   
                WHERE (u.id_usuario = '$this->id_usuario'  AND u.estado = 'A' and u.passw='$this->passw');";

        $datos = $cnx->query($sql);
        foreach ($datos as $result) {
            if ($result['id_usuario'] == $this->id_usuario) {
                if ($result['passw'] == $this->passw) {

                    if ($result['estado'] == 'X') {
                        echo $this->id_usuario . "Usuario Deshabilitado. Pongase en contacto con el Administrador";
                    }
                    $_SESSION['s_id_usuario'] = $result['id_usuario'];
                    $_SESSION['s_usuario'] = $result['fullname'];
                    $_SESSION['s_rol'] = $result['rol'];
                    $_SESSION['s_id_rol'] = $result['id_rol'];
                    $_SESSION['s_tiempo'] = time();
                    $_SESSION['s_fin'] = $_SESSION['s_tiempo'] + (5 * 60);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        $cnx->CloseConnection();
    }

    /* ------------------------------------------------------------------ */

    public function set($user_data = array()) {
        if (array_key_exists('email', $user_data)):
            $this->get($user_data['email']);
            if ($user_data['email'] != $this->email):
                foreach ($user_data as $campo => $valor):
                    $campo = $valor;
                endforeach;
                $this->query = "INSERT INTO usuarios(nombre, apellido, email, clave) "
                        . "VALUES ('$nombre', '$apellido', '$email', '$clave')";
                $this->execute_single_query();
            endif;
        endif;
    }

    /* ======================================================================== */

    public function retrive_all() {
        $conex = new ConexPDO();

        if ($conex) {
            $sql = "SELECT ur.id_usuario_rol, u.id_usuario,concat_ws(' ', nombres, apellidos) as usuario,
                    r.id_rol, r.rol,e.estado
                    FROM tb_empleados e
                        JOIN tb_usuarios u ON e.id_empleado = u.id_usuario
                        JOIN tb_usuarios_roles ur ON u.id_usuario = ur._id_usuario
                        JOIN tb_roles r ON ur._id_rol = r.id_rol";
            $result = $conex->query($sql);

            if ($result) {

                return $result;
            } else {
                return false;
            }

            $conex->CloseConnection();
        }
    }

    public function update_usuario_rol($id_usuario_rol, $_id_rol, $_id_usuario, $estado) {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "UPDATE tb_usuarios_roles SET _id_rol='$_id_rol',estado='$estado'
                         WHERE id_usuario_rol='$id_usuario_rol' and _id_usuario='$_id_usuario'";
                $result = mysql_query($sql);
                if ($result > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function camposTabla() {
        return getCamposTabla($this->tabla);
    }

    function __construct() {
        
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function getPassw() {
        return $this->passw;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setPassw($passw) {
        $this->passw = $passw;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    function getPassw_new() {
        return $this->passw_new;
    }

    function setPassw_new($passw_new) {
        $this->passw_new = $passw_new;
    }

}
