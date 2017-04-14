<?php
require_once 'model/conexDB/ConexPDO.php';
include_once 'model/generico/Funciones.php';


class Proveedor {

    var $id_proveedor;
    var $_id_usario;
    var $ruc;
    var $nombres;
    var $correo;
    var $telefono;
    var $direccion;
    var $estado;

    private $attrib = array();
    protected $tabla = "tb_proveedores";
    
    function __construct() {
        
    }

    function get_id_usario() {
        return $this->_id_usario;
    }

    function set_id_usario($_id_usario) {
        $this->_id_usario = $_id_usario;
    }

    function getId_proveedor() {
        return $this->id_proveedor;
    }

    function getRuc() {
        return $this->ruc;
    }

    function getNombres() {
        return $this->nombres;
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

    function setId_proveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
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

    public function create_proveedor_factura() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_factura_compras('$this->id_proveedor','$this->')";
            if (!mysql_query($sql)) {
                echo "Falló la llamada: (" . mysql_errno() . ") " . mysql_error();
            }
            $conex->desconectar();
            return true;
        } else {
            echo 'ERROR DE CONEXION CON DB';
        }
    }

    public function create() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "call pa_crear_proveedores('$this->ruc','$this->nombres',
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
                $sql = "UPDATE tb_proveedores SET nombres='$this->nombres',
                        correo='$this->correo',telefono='$this->telefono',direccion='$this->direccion',
                        estado='$this->estado' WHERE ruc='$this->ruc'";
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
                $sql = "DELETE FROM  tb_proveedores WHERE ruc='$this->ruc'";
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

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM $this->tabla";
            $result = $conex->query($sql);         
            if (($result)) {
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
            $sql = "SELECT * FROM tb_proveedores                
                   WHERE (ruc LIKE '%$this->id_proveedor%') OR (nombres  LIKE '%$this->id_proveedor%')";
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

   public function camposTabla() {
        return getCamposTabla($this->tabla);
    }

}
