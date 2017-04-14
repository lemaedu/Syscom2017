<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'model/facturas/FacturaCompras.php';
require_once 'model/facturas/FacturaDetalleCompras.php';

class C_FacturaCompras {

    //put your code here
    //************ PARA FACTURA COMPRAS**********************************-----/


    public function crear_factura_compras() {

        try {
            $nObj = new FacturaCompras();
            $nObj->set_ruc($_POST['btnFact']);
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            $nObj->setId_factura($_POST['factura']);
            $nObj->setFecha_compra($_POST['fecha']);

            if ($nObj->create_factura_compras()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function crear_detalle_factura_compras() {

        try {
            $nObj = new FacturaCompras();
            $nObj->set_id_factura($_POST["nombres"]);
            $nObj->set_id_producto($_id_producto);
            $nObj->setCantidad($cantidad);
            $nObj->setValor_compra($valor_compra);
            $nObj->setStok($stok);
            $nObj->setDescuento($descuento);
            $nObj->setValor_venta($valor_venta);

            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function crear() {

        try {
            $nObj = new FacturaCompras();
            $nObj->set_id_factura($_POST["nombres"]);
            $nObj->set_id_producto($_id_producto);
            $nObj->setCantidad($cantidad);
            $nObj->setValor_compra($valor_compra);
            $nObj->setStok($stok);
            $nObj->setDescuento($descuento);
            $nObj->setValor_venta($valor_venta);

            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function crear_factura_detalle($factura) {
        try {
            $nObj = new FacturaDetalleCompras();
            $nObj->set_id_factura($factura);
            $nObj->set_id_producto($_POST['id_producto']);
            $nObj->setCantidad($_POST['cantidad']);
            $nObj->setValor_compra($_POST['valor_compra']);
            $nObj->setStok($_POST['cantidad']);
            $nObj->setDescuento($_POST['descuento']);

            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function actualizar_factura_detalle() {
        try {
            $nObj = new FacturaDetalleCompras();

            $nObj->setId_compras($_POST['id_act']);
            //$nObj->set_id_producto($_POST['id_producto']);
            $nObj->setCantidad($_POST['cantidad_act']);
            $nObj->setValor_compra($_POST['p_unitario_act']);
            $nObj->setStok($_POST['cantidad_act']);
            $nObj->setDescuento($_POST['descuento_act']);
            $nObj->setValor_venta($_POST['valor_venta']);

            if ($nObj->actualizar_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function actualizar_factura_detalle_stok() {
        try {
            $nObj = new FacturaDetalleCompras();

            $nObj->setId_compras($_POST['id_act']);
            $nObj->set_id_factura($_POST['factura']);    
            $nObj->setStok($_POST['stok_act']);

            if ($nObj->actualizar_detalle_factura_stok()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function eliminar_factura_detalle($factura) {
        try {
            $nObj = new FacturaDetalleCompras();
            $nObj->set_id_factura($factura);
            $nObj->setId_compras($_POST['id_transaccion']);

            if ($nObj->eliminar_registro_detalle_factura()) {
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
            $nObj = new Categoria();
            $nObj->setId_categoria($_POST["id"]);
            $nObj->setNombres($_POST["nombres"]);
            $nObj->setDescripcion($_POST["descripcion"]);
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

    public function listar_detalle_compras($factura) {
        try {
            $nObj_control = new FacturaDetalleCompras();
            $nObj_control->set_id_factura($factura);
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_compras()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function listar_detalle_compras_stok($factura) {
        try {
            $nObj_control = new FacturaDetalleCompras();
            $nObj_control->set_id_factura($factura);
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_compras_stok()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function total_factura_compras($factura) {
        try {
            $nObj_control = new FacturaDetalleCompras();
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);       
            $nObj_control->set_id_factura($factura);            
            if ($lista_control = $nObj_control->retrive_detalle_factura_compras_total()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function eliminar() {
        try {

            $nObj = new Categoria();
            $nObj->setId_categoria($_POST["id"]);
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

    function buscar() {
        $nObj = new Categoria();
        $nObj->setNombres($_POST["buscar"]);
        if ($nObj->search()) {
            return $nObj->search();
        } else {
            return false;
        }
    }

    public function getCampos() {
        $nObj_control = new Categoria();
        if ($lista_control = $nObj_control->camposTabla()) {
            return $lista_control;
        } else {
            return false;
        }
    }

    /* LISTA FACTURA COMPRAS */

    public function listaFacturaCompras() {
        try {

            $nObj = new FacturaCompras();
            if ($datos = $nObj->r_listarFacturaCompras()) {
                return $datos;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

}
