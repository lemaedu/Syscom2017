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
    /* ---------------- */
    private $attrib = array();
    protected $tabla = "tb_productos";

    function __construct() {
        
    }

//Metodo magico utilizado para __set y __get
    public function __call($method, $args) {
        $methodType = substr($method, 0, 3);
        $attribName = strtolower(substr($method, 3));
        $claseName = get_class($this);
        if ($methodType == "set") {
            if (property_exists($claseName, $attribName)) {
                $this->setAttrib($attribName, $args[0]);
            } else {
                echo "No existe el atributo $attribName.";
            }
        }
        if ($methodType == "get") {
            if (property_exists($claseName, $attribName)) {
                return $this->getAttrib($attribName);
            } else {
                echo 'Método no definido <br/>';
            }
        }
    }

    private function setAttrib($attribName, $value) {
        $this->attrib[$attribName] = "$value";
    }

    private function getAttrib($attribName) {
        return $this->attrib[$attribName];
    }

    public function create() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "Insert Into tb_productos(codigo_barras,nombres,_id_categoria,_id_marca,descripcion)
                    VALUES( '$this->codigo_barras','$this->nombres', '$this->_id_categoria',  
                            '$this->_id_marca','$this->descripcion')";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function update() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "UPDATE tb_productos SET codigo_barras='$this->codigo_barras', nombres='$this->nombres',_id_categoria='$this->_id_categoria', _id_marca='$this->_id_marca',
                        imagen='$this->imagen',estado='$this->estado'
                         WHERE id_producto='$this->id_producto'";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function delete() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "DELETE FROM  tb_productos WHERE id_producto='$this->id_producto'";
            $result = $conex->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
            $conex->CloseConnection();
        }
    }

    public function retrive() {
        $conex = new ConexPDO();
        if ($conex) {
            $sql = "SELECT * FROM v_producto_marca_categoria order by id_producto";
            $result = $conex->query($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            $conex->CloseConnection();
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

    public function search_productos_disponibles_venta_cod_barr() {
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

    public function search_productos_disponibles_venta2() {
        $conexion = new ConexPDO();
        if ($conexion) {
            try {
                $dato = $this->nombres;
                $sql = "SELECT id_compras,producto,codigo_barras, valor_venta,stok, fecha_compra,id_factura,id_producto
                    FROM v_productos_disponibles_venta
                    WHERE producto LIKE '%$dato%' or codigo_barras LIKE'%$dato%'";

                $resultado = $conexion->query($sql);
                $listaR = $resultado->fetchAll();
                return $listaR;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            return false;
        }
    }

}
