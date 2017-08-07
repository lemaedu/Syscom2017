<?php

// Autor Syscom
//Clase donde Direcciona a cada vista
class controlador_mvc {

    private $pag;

    function __construct() {
        $this->pag = $this->pag;
    }

    public function render() {
//$_GET['pag'] trae valor de los o numero de Pagina por get
        if (isset($_GET['pag'])) {
            $this->_prepararDatos();
            switch ($this->pag) {
                case "0":$this->pag_0();break;
                case "1":$this->pag_1(); break;
                case "2":$this->pag_2(); break;
                case "3":$this->pag_3(); break;
                case "4":$this->pag_4(); break;
                case "5":$this->pag_5(); break;
                case "6":$this->pag_6(); break;
                case "7":$this->pag_7(); break;
                case "8":$this->pag_8(); break;
                case "9":$this->pag_9(); break;
                case "10":$this->pag_10(); break;
                case "11":$this->pag_11(); break;
                case "12":$this->pag_12(); break;
                case "13":$this->pag_13(); break;
                case "14":$this->pag_14(); break;
                case "15":$this->pag_15(); break;
                case "16":$this->pag_16(); break;
                case "17":$this->pag_17(); break;
                case "18":$this->pag_18(); break;
                case "19":$this->pag_19(); break;
                /* SECCION REPORTES ****** */
                case "20":$this->pag_20(); break;
                case "21":$this->pag_21(); break;
                /*                 * ********************** */
                /* SECCION FACTURAS VENTAS */
                case "30":$this->pag_30(); break;
                case "31":$this->pag_31(); break;
                
                case "40":$this->pag_40(); break;
                
                case "101":$this->pag_101(); break;
                case "102":$this->pag_102(); break;
                case "103":$this->pag_103(); break;
            }
        } else {
            $this->pag_home();
        }
    }

    protected function _prepararDatos() {
        $this->pag = trim($_GET['pag']);
        return;
    }

//carga la pagina principal por defecto
    public function pag_home() {
        require_once 'view/user/login.php';
    }

    public function pag_0() {
        require_once 'view/home.php';
    }
     public function pag_1() {
        require_once 'view/seguridad/grupos.php';
    }

    public function pag_2() {
        require_once 'view/seguridad/opciones.php';
    }

    public function pag_3() {
        require_once 'view/seguridad/menu.php';
    }

    public function pag_4() {
        require_once 'view/seguridad/roles.php';
    }

    public function pag_5() {
        require_once 'view/seguridad/usuarios.php';
    }

    public function pag_6() {
        require_once 'view/seguridad/roles.php';
    }

    public function pag_7() {
        require_once 'view/seguridad/roles.php';
    }

    public function pag_8() {
        require_once 'view/productos/categorias.php';
    }

    public function pag_9() {
        require_once 'view/productos/marcas.php';
    }

    public function pag_10() {
        require_once 'view/productos/productos.php';
    }

    public function pag_11() {
        require_once 'view/actores/cliente.php';
    }

    public function pag_12() {
        require_once 'view/actores/proveedores.php';
    }

    public function pag_13() {
        require_once 'view/facturas/listadoFacturasVendidas.php';
    }

    public function pag_14() {
        require_once 'view/facturas/homeFacturaVentas.php';
    }

    public function pag_15() {
        require_once 'view/facturas/facturaCompras.php';
//        require_once 'view/facturas/historialFacturaCompras.php';
    }

    public function pag_16() {
        require_once 'view/productos/productos.php';
    }

    public function pag_17() {
        require_once 'view/facturas/actulaizarStok.php';
    }

    //pedidos
    public function pag_18() {
        require_once 'view/Reportes/RepFacturaVentas.php';
    }
    
    //consulta presios
    public function pag_19() {
        require_once 'view/facturas/actulaizarStok.php';
    }
    
    public function pag_100() {
        require_once 'view/seguridad/grupos.php';
    }

    public function pag_101() {
        require_once 'view/usuario/cambiarClave.php';
    }

    public function pag_102() {
        require_once 'view/usuario/actualizarPerfil.php';
    }

    public function pag_103() {
        require_once 'view/usuario/logout.php';
    }

    public function pag_200() {        
        require_once 'view/facturas/facturacion.php';
    }

    //------------------------ SOLO REPORTES ----------------------------------//

    public function pag_20() {
        require_once 'view/Reportes/RepFacturaVentas.php';
    }

    public function pag_21() {
        require_once 'view/Reportes/RepFacturaVentas1.php';
    }
    //---------------------------------factura ventas--------------------------//

    public function pag_30() {
        require_once 'view/facturas/facturasVentas.php';
    }

     public function pag_31() {
        require_once 'view/facturas/historialFacturaVentas.php';
    }
    public function pag_40() {
        require_once 'view/productos/actuliazarProd.php';
    }


}
