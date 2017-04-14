<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?pag=0"><?php echo $_SESSION['s_rol'] ?></a>
        </div>
        <ul class="nav navbar-nav " >
            <?php
            require_once 'controller/segurity/C_rol.php';
            $i_rol = $_SESSION['s_id_rol'];
            $nEm = new C_rol();
            $lista = $nEm->_set($i_rol);
            if ($lista != NULL) {
                $grupo = ""; /* ---CONTENIDO SUPERIOR del menu---- */
                $opciones = ""; /* ---CONTENIDO INFERIOR DENTRO DEL GRUPO */
                $p = 0;
                foreach ($lista as $menu) {
                    $opciones = $menu['opcion'];
                    $contenido = $menu['contenido'];
                    if ($grupo != $menu["grupo"]) {
                        $i = 0;
                        if ($i == $p) {
                            $grupo = $menu["grupo"];
                            echo '<li class="dropdown">
                                        <a id="drop1" class="dropdown-toggle" data-toggle="dropdown">' . $grupo . '<span class="caret"></span></a>
                                        <ul class="dropdown-menu" >
                                            <li>
                                                <a href="'.$contenido .'"> '.$opciones.'</a>
                                            </li>';
                            $i++;
                            $p = $i;
                        } else {
                            $grupo = $menu["grupo"];
                            echo '  </ul>
                                        </li> 
                                        <li class="dropdown"><a id="drop"  class="dropdown-toggle" data-toggle="dropdown">' . $grupo . '<span class="caret"></span></a>
                                            <ul class="dropdown-menu" >
                                                <li>
                                                    <a href="'.$contenido.'">'.$opciones.'</a>
                                                </li>';
                            $i++;
                            $p = $i;
                        }
                    } else {
                        echo '<li>
                                    <a href="'.$contenido .'">'.$opciones .'</a>
                                       </li>';
                        $i++;
                        $p = $i;
                    }
                }
                echo '</ul>
                </li>';
            }
            ?>  
        </ul>

        <ul class="nav navbar-nav navbar-right">            
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span><strong> SALIR</strong> </a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Hola! <?php echo $_SESSION['s_usuario'] ?>
                    <span class="caret"></span>
                </a>             
                <ul class="dropdown-menu" >
                    <li ><a href="index.php?pag=102"><span class="glyphicon glyphicon-wrench"></span> ACTUALIZAR DATOS</a></li>
                    <li><a href="index.php?pag=101"><span class="glyphicon glyphicon-refresh"></span> CAMIAR CONTRASEÑA</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?pag=103"><span class="glyphicon glyphicon-off"></span> SALIR</a></li>
                </ul>
            </li>
        </ul> 
    </div>
</nav>



