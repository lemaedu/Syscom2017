<?php

$objCat = new C_Categoria();
$objMarca = new C_Marca();
$datosCategoria = $objCat->listar();
$datosMarca = $objMarca->listar();

?>
<div class="modal fade" id="actualizar<?php echo $fila[0] ?>" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="form2" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?php echo $fila[0] ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title">ACTUALIZAR REGISTRO</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">                                            
                            <strong>CATEGORIA</strong><br>
                            <div class="form-group">                        
                                <select class="form-control" name="categoria">
                                    <option value="<?php // echo $fila[2]  ?>"><?php // echo $fila[3]  ?></option>
                                    <?php                                    
                                    if ($datosCategoria != NULL) {
                                        foreach ($datosCategoria as $categoria) {
                                            ?>                                                    
                                            <option value="<?php echo $categoria[0] ?>"><?php echo $categoria[1] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>                          
                                </select>
                            </div> 
                            <div class="form-group">
                                <strong>MARCA</strong><br>
                                <select class="form-control" name="marca">
                                    <option value="<?php // echo $fila[5]  ?>"><?php // echo $fila[6]  ?></option>
                                    <?php                                    
                                    if ($datosMarca != NULL) {
                                        foreach ($datosMarca as $marca) {
                                            ?>                                                    
                                            <option value="<?php echo $marca[0] ?>"><?php echo $marca[1] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>                                     
                            </div>
                            <strong>CODIGO BARRAS</strong><br>
                            <input type="text" name="codigo_barras" class="form-control" value="<?php // echo $fila[1];  ?>"><br>

                            <strong>NOMBRE</strong><br>
                            <textarea class="form-control" rows="2" name="nombre" ><?php // echo $fila[4];  ?></textarea><br>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <label align="center">IMAGEN</label>
                                    <a href="#" class="thumbnail">
                                        <img src="extras/img/blanco.png">
                                    </a>
                                </div>                                        
                            </div> 
                            <input name="uploadedfile" type="file"/><br>
                            <center><button type="submit" class="btn btn-success" name="actualizar"><strong><i class="icon-ok"></i>ACTUALIZAR</strong></button></center>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminar<?php echo $fila[0] ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="form2" method="post" enctype="multipart/form-data" action="" id="eliminar">
                <input type="hidden" name="id" value="<?php echo $fila[0] ?>" id="id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title">ELIMINAR REGISTRO</h3>
                </div> 
                <div class="modal-body alert-danger">
                    <div class="alert-danger" align="center">ESTA SEGURO QUE DESEA ELIMINAR EL EQUIPO</div>
                    <div align="center"><?php echo $fila[0] . ' ' . $fila[1] ?></div><br>

                    <div class="row-fluid">
                        <div class="span6">
                            <center><button type="submit" class="btn btn-default" name="cancelar" ><strong><span class="glyphicon glyphicon-stop"></span> CANCELAR</strong></button></center>
                        </div>
                        <div class="span6">
                            <center><button type="submit" class="btn btn-danger" name="eliminar" ><strong><span class="glyphicon glyphicon-trash"></span> ELIMINAR EQUIPO</strong></button></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="nuevo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="form2" method="post" enctype="multipart/form-data" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" >×</button>
                    <h3 class="modal-title">FORMULARIO DE INGRESO</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="form-group">  
                                <strong>CATEGORIA</strong><br>
                                <select class="form-control" name="categoria">
                                    <?php                                                                        
                                    if ($datosCategoria != NULL) {
                                        foreach ($datosCategoria as $categoria) {
                                            ?>                                                    
                                            <option value="<?php echo $categoria[0] ?>"><?php echo $categoria[1] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>                                     
                            </div>
                            <div class="form-group">
                                <strong>MARCA</strong><br>
                                <select class="form-control" name="marca">
                                    <?php                                                                        
                                    if ($datosMarca != NULL) {
                                        foreach ($datosMarca as $marca) {
                                            ?>                                                    
                                            <option value="<?php echo $marca[0] ?>"><?php echo $marca[1] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>                                     
                            </div>                                    
                            <strong>CODIGO DE BARRAS</strong><br>                             
                            <input type="text" class="form-control" name="codigo_barras" placeholder="Campo de texto"><br>
                            <strong>NOMBRE</strong><br>                            
                            <textarea class="form-control" rows="3" name="nombre"></textarea> 
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <label align="center">IMAGEN</label>
                                    <a href="#" class="thumbnail">
                                        <img src="extras/img/blanco.png"  >
                                    </a>
                                </div>                                        
                            </div> 
                            <input name="uploadedfile" type="file"/><br>
                        </div>
                    </div>&nbsp;
                    <center><button type="submit" class="btn btn-info" name="crear"><strong><span class="glyphicon glyphicon-ok"></span> INGRESAR</strong></button></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>    