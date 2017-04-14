<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function div_pendiente($dato) {
    ?>
    <div class="modal fade" id="pendiente<?php echo $dato; ?>"role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="form2" method="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="id_factura_cerrar" value="<?php echo $dato; ?>">
                    <input type="hidden" name="estado" value="2">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title">FACTURA PENDIENTE
                        </h3>
                    </div> 
                    <div class="modal-body alert-info">
                        <div class="row">
                            <div class="alert-info" align="center">¿ESTA SEGURO QUE DESEA PONER EN PENDIENTE LA FACTURA?</div>
                            <div align="center">El Usuario debera esperar para continuar con la tranzaccion</div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-default" name="cancelar" ><strong> CANCELAR</strong></button></center>
                                </div>
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-success" name="btn_cerrar_factura" ><strong>ACEPTAR</strong></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

function div_cobrar($dato ,$totalNeto) {
    ?>
    <div class="modal fade" id="cobrar<?php echo $dato; ?>"role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="form2" method="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="id_factura_cerrar" value="<?php echo $dato; ?>">
                    <input type="hidden" name="estado" value="3">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title">COBRAR FACTURA</h3>
                    </div> 
                    <div class="modal-body alert-info">
                        <div class="row">
                            <div class="alert-info" align="center"><h1><strong>TOTAL: </strong>$<?php echo $totalNeto?> </h1></div>
                            <div align="center"></div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-default" name="cancelar" ><strong> CANCELAR</strong></button></center>
                                </div>
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-success" name="btn_cerrar_factura" ><strong>ACEPTAR</strong></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

function div_cerrar($dato) {
    ?>
    <div class="modal fade" id="cerrar<?php echo $dato ?>"
         role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="form2" method="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="id_factura_cerrar" value="<?php echo $dato ?>">
                    <input type="hidden" name="estado" value="0">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title">CERRAR FACTURA</h3>
                    </div> 
                    <div class="modal-body alert-info">
                        <div class="row">
                            <div class="alert-info" align="center">¿ESTA SEGURO QUE DESEA CERRAR LA FACTURA?</div>
                            <div align="center">Si Cierra la factura no podrá agregar más registros</div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-default" name="cancelar" ><strong> CANCELAR</strong></button></center>
                                </div>
                                <div class="col-md-6">
                                    <center><button type="submit" class="btn btn-success" name="btn_cerrar_factura" ><strong>CERRAR FACTURA</strong></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
