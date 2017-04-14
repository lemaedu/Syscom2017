<?php

require_once 'model/ConexDB/ConexPDO.php';

class Clientes {

    var $id_cliente;
    var $nombre;
    var $cedula;
    var $correo;
    var $telefono;
    var $direccion;
    var $estado;

    function __construct() {
        
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function create() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_cliente('$this->nombre','$this->cedula',
                            '$this->correo','$this->telefono','$this->direccion')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }


    public function update() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            try {
                $sql = "UPDATE tb_clientes SET nombres='$this->nombre',cedula='$this->cedula',
                        correo='$this->correo',telefono='$this->telefono',direccion='$this->direccion',
                        estado='$this->estado' WHERE id_cliente='$this->id_cliente'";
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

    public function delete() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {            
            try {
                $sql = "delete FROM tb_clientes
                        WHERE id_cliente='$this->id_cliente'";
                if (!mysql_query($sql)) {
                    echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
                    return false;
                }
                $conex->desconectar();
                return true;
            } catch (Exception $ex) {
                echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
            }
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM tb_clientes ";
            $result = $conex->query($sql);            
            if ($result ) {                
                return $result;
            } else {
                return false;
            }            
            $conex->CloseConnection();
        } else {
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function search() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {

            $sql = "SELECT * FROM tb_clientes
                    WHERE (cedula LIKE '%$this->id_cliente%') OR (nombres  LIKE '%$this->id_cliente%')";
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
            echo 'ERROR CON DB';
            return false;
        }
    }

    public function search1() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "SELECT * FROM tb_clientes
                    WHERE (id_cliente ='$this->cedula')";
            $result = mysql_query($sql);
            $numero_filas = mysql_num_rows($result);

            if (($result) && ($numero_filas > 0)) {
                while ($lista_temporal = mysql_fetch_assoc($result)) {
                    $lista_resultados[] = $lista_temporal;
                }
                return $lista_resultados;
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

}
