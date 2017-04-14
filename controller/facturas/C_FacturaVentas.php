<?php

//require_once 'vista/ingresos/V_ingresarEquipo.php';
require_once 'modelo/facturas/FacturaVentas.php';
require_once 'modelo/facturas/FacturaDetalleVentas.php';

class C_FacturaVentas {

    //put your code here
    public function crear() {

        try {
            $nObj = new FacturaVentas();

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
            $nObj = new FacturaDetalleVentas();
            $nObj->set_id_factura($factura);
            $nObj->set_id_producto($_POST['id_producto']);
            $nObj->setCantidad($_POST['cantidad']);
            $nObj->setPrecio_venta($_POST['valor_venta']);
            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function agregar_producto_factura($factura) {
        try {
            $nObj = new FacturaDetalleVentas();
            $nObj->set_id_factura($factura);
            $nObj->set_id_producto($_POST['id_producto']);
            $nObj->setCantidad($_POST['cantidad']);
            $nObj->setPrecio_venta($_POST['valor_venta']);
            $nObj->set_id_transaccion_venta($_POST['id_compra']);

            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function agregar_producto_factura_codBarr($factura, $id_prod, $cant, $valorVenta, $id_comp) {
        try {
            $nObj = new FacturaDetalleVentas();
            $nObj->set_id_factura($factura);
            $nObj->set_id_producto($id_prod);
            $nObj->setCantidad($cant);
            $nObj->setPrecio_venta($valorVenta);
            $nObj->set_id_transaccion_venta($id_comp);
            if ($nObj->create_detalle_factura()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function actualizar_factura_detalle_ventas($factura) {
        try {
            $nObj = new FacturaDetalleVentas();
            $nObj->set_id_factura($factura);
            $nObj->setId_venta($_POST['id_act']);
            $nObj->setCantidad($_POST['cantidad_act']);
            $nObj->setPrecio_venta($_POST['p_unitario_act']);
            $nObj->setDescuento($_POST['descuento_act']);
            if ($nObj->actualizar_detalle_factura_ventas()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function eliminar_detalle_factura_ventas($factura) {
        try {
            $nObj = new FacturaDetalleVentas();
            $nObj->set_id_factura($factura);
            $nObj->setId_venta($_POST['id']);
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

    public function listar_detalle_ventas($factura) {
        try {
            $nObj_control = new FacturaDetalleVentas();
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

    public function detalle_factura_ventas($factura) {
        try {
            $nObj_control = new FacturaDetalleVentas();
            $nObj_control->set_id_factura($factura);
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_ventas()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function detalle_factura_ventas_por_numero($factura) {
        try {
            $nObj_control = new FacturaDetalleVentas();
            $nObj_control->set_id_factura($factura);
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_ventas_por_numero()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function total_factura_ventas() {
        try {
            $nObj_control = new FacturaDetalleVentas();
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_ventas_total()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function total_ventas_por_factura($numeroFactura) {
        try {
            $nObj_control = new FacturaVentas();
            $nObj_control->setId_factura($numeroFactura);
            if ($lista_control = $nObj_control->retrive_total_venta_por_factura()) {
                return $lista_control;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function descuento_factura_ventas() {
        try {
            $nObj_control = new FacturaDetalleVentas();
            $nObj_control->setId_empleado($_SESSION['s_id_usuario']);
            if ($lista_control = $nObj_control->retrive_detalle_factura_ventas_descuento()) {
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

    public function FacturaActivada() {
        try {

            $nObj = new FacturaVentas();
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

    public function FacturaNumero($numeroFactura) {
        try {

            $nObj = new FacturaVentas();
            $nObj->setId_factura($numeroFactura);
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);

            if ($datos = $nObj->retriveFacturaNumero()) {
                return $datos;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function crear_factura_venta($fecha) {

        try {
            $nObj = new FacturaVentas();
            $nObj->set_id_cliente($_POST['btnOk']);
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            $nObj->setFecha_venta($fecha);
            if ($nObj->create_factura_ventas()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron ingresar los datos Error" . $ex->getMessage();
        }
    }

    public function cerrarFacturaActivada() {
        try {
            $nObj = new FacturaVentas();
            $nObj->setId_factura($_POST['id_factura_cerrar']);
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            $nObj->setEstado($_POST['estado']);
            if ($nObj->closeFacturaAcctivaVentas()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    /*     * ======================================================= */

    public function listaFacturaVentas() {
        try {

            $nObj = new FacturaVentas();
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);

            if ($datos = $nObj->retriveListaFacturaVentas()) {
                return $datos;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    public function historialFacturaVentas($fecha) {
        try {

            $nObj = new FacturaVentas();
            $nObj->set_id_empleado($_SESSION['s_id_usuario']);
            $nObj->setFecha_venta($fecha);
            if ($datos = $nObj->retriveHistorialFacturaVentas()) {
                return $datos;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return false;
        }
    }

    function cambiarestadoFactura() {
        try {
            $nObj = new FacturaVentas();
            $nObj->setId_factura($_POST['btnEstado']);
            $nObj->setEstado($_POST['btnEstado']);
            if ($nObj->updateEstadoFactura()) {
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
