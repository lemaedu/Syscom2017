<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 * @author SYSCOM
 */
require_once 'modelo/ConexDB/conexionMYSQL.php';
require_once 'modelo/ConexDB/MysqlPDO.php';

class Persona {

    private $cedula;
    private $nombres;
    private $apellidos;
    private $nacimiento;
    private $Sexo;

    function __construct() {
        
    }

    function getCedula() {
        return $this->cedula;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNacimiento() {
        return $this->nacimiento;
    }

    function getSexo() {
        return $this->Sexo;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNacimiento($nacimiento) {
        $this->nacimiento = $nacimiento;
    }

    function setSexo($Sexo) {
        $this->Sexo = $Sexo;
    }

}

class Empleado extends Persona {

    private $correo;
    private $nacionalidad;
    private $telefono;
    private $direccion;
    private $foto;
    private $estado;

    function __construct() {
        parent::__construct();
    }

    function getCorreo() {
        return $this->correo;
    }

    function getNacionalidad() {
        return $this->nacionalidad;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getFoto() {
        return $this->foto;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function create() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $ced = $this->getCedula();
                $nom = $this->getNombres();
                $ape = $this->getApellidos();
                $nac = $this->getNacimiento();
                $sex = $this->getSexo();

                $sql1 = "INSERT INTO tb_empleados(id_empleado, nombres, apellidos, nacimiento, sexo, 
                        correo, nacionalidad, telefono, direccion, foto, estado)
                        VALUES ('$ced', '$nom ', '$ape', '$nac', '$sex', '$this->correo', '$this->nacionalidad',
                         '$this->telefono', '$this->direccion', '$this->foto', '$this->estado');";

                $result = mysql_query($sql1);
                if ($result > 0) {
                    return true;
                    echo 'Holaaaaaq';
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

    function retrive() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "SELECT * FROM tb_empleados";
            $result = mysql_query($sql);
            $num_col = mysql_num_rows($result);
            if (($result) && ($num_col > 0)) {
                while ($lista = mysql_fetch_row($result)) {
                    $lista_[] = $lista;
                }
                return $lista_;
            } else {
                return false;
            }
            mysql_free_result($result);
            $conex->desconectar();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function search1() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {

            $b = $this->getCedula();

            $sql = "SELECT id_empleado,nombres,apellidos,nacimiento,sexo,correo,nacionalidad,telefono,direccion FROM tb_empleados
                    WHERE (id_empleado ='$b')";
            $result = mysql_query($sql);
            $numero_filas = mysql_num_rows($result);

            if (($result) && ($numero_filas > 0)) {
                while ($lista_temporal = mysql_fetch_row($result)) {
                    $lista_resultados[] = $lista_temporal;
                }
                return $lista_resultados;
            } else {
                return false;
            }
            mysql_free_result($result);
            $conex->desconectar();
        } else {
            return false;
        }
    }

    public function update() {
        $conexion = new MysqlPDO();
        if ($conexion) {
            try {
                $ced = $this->getCedula();
                $nom = $this->getNombres();
                $ape = $this->getApellidos();
                $nac = $this->getNacimiento();
                $sex = $this->getSexo();

                $sql = "call pa_actualizar_empleado('$ced','$nom','$ape','$nac','$sex','$this->correo',
                        '$this->nacionalidad','$this->telefono','$this->direccion','$this->foto')";
                $stm = $conexion->prepare($sql);
                if ($stm->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        }
    }

    public function delete() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $ced = $this->getCedula();
                $sql = "DELETE FROM  tb_empleados WHERE id_empleado='$ced'";
                if (mysql_query($sql) > 0) {//Si es distinto de 1 ; si no se ejecuta                
                    return true;
                } else {
                    return false;
                }
                $conex->desconectar();
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    function getCamposTabla() {
        include_once 'modelo/Funciones.php';
        $tabla = "tb_empleados";
        return getCamposTabla($tabla);
    }

}
