<?php

require_once 'model/ConexDB/ConexPDO.php';

class Producto {

    var $id_producto;
    var $codigo_barras;
    var $_id_categoria;
    var $_id_marca;
    var $nombres;
    var $imagen;
    var $descripcion;
    var $estado;

    function __construct() {
        
    }

    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function getCodigo_barras() {
        return $this->codigo_barras;
    }

    function setCodigo_barras($codigo_barras) {
        $this->codigo_barras = $codigo_barras;
    }

    function getId_producto() {
        return $this->id_producto;
    }

    function get_id_categoria() {
        return $this->_id_categoria;
    }

    function get_id_marca() {
        return $this->_id_marca;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function set_id_categoria($_id_categoria) {
        $this->_id_categoria = $_id_categoria;
    }

    function set_id_marca($_id_marca) {
        $this->_id_marca = $_id_marca;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function create() {
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "Insert Into tb_productos(codigo_barras,nombres,_id_categoria,_id_marca,descripcion)
                    VALUES( '$this->codigo_barras','$this->nombres', '$this->_id_categoria',  
                            '$this->_id_marca','$this->descripcion')";
            $result = mysql_query($sql);
            if (!$result) {//Si es distinto de 1 ; si no se ejecuta                
                return false;
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
                $sql = "UPDATE tb_productos SET codigo_barras='$this->codigo_barras', nombres='$this->nombres',_id_categoria='$this->_id_categoria', _id_marca='$this->_id_marca',
                        imagen='$this->imagen',estado='$this->estado'
                         WHERE id_producto='$this->id_producto'";
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
                $sql = "DELETE FROM  tb_productos WHERE id_producto='$this->id_producto'";
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
        $conex = new conexionMYSQL();
        if ($conex->conectar()) {
            $sql = "SELECT * FROM v_producto_marca_categoria order by id_producto";
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

    public function retrive1() {
        $conexion = new ConexPDO();
        if ($conexion) {
            $sql = "SELECT * FROM v_producto_marca_categoria order by id_producto ";
            $stm = $conexion->query($sql);
            return $stm;
        }
    }

    public function search() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql1 = "SELECT * FROM v_producto_marca_categoria
                    WHERE producto LIKE '%$this->descripcion%' or codigo_barras LIKE '%$this->descripcion%' ";
            $result = $conex->query($sql1);
            if ($result) {
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

    public function search_productos_disponibles_venta1() {
        $conex = new ConexPDO();
        if ($conex) {

            $sql = "SELECT id_compras,producto,codigo_barras, valor_venta,stok, fecha_compra,id_factura,id_producto
                    FROM v_productos_disponibles_venta
                    WHERE codigo_barras='$this->id_producto'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function search_productos_disponibles_venta() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT id_compras,producto,codigo_barras, valor_venta,stok, fecha_compra,id_factura,id_producto
                    FROM v_productos_disponibles_venta
                    WHERE producto LIKE '%$this->descripcion%' or codigo_barras LIKE'%$this->descripcion%'";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

}
