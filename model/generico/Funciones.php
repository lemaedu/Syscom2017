<?php

include_once 'model/conexDB/ConexPDO.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getCamposTabla($nombreTabla) {

    $conexion = new ConexPDO();
    if ($conexion) {
        try {
            $sql = "SHOW COLUMNS FROM $nombreTabla";
            $resultado = $conexion->query($sql);            
            return $resultado;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } else {
        return false;
    }
}

function getDatosTabla($nombreTabla) {    
    $conexion = new ConexPDO();
    if ($conexion) {
        try {
            $sql = "select * FROM $nombreTabla";
            $resultado = $conexion->query($sql);            
            return $resultado;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } else {
        return false;
    }
}

function execute_pa($procedimiento_almacenado, $valor) {
    $conexion = new ConexPDO();
    if ($conexion) {
        try {
            $sql = "call $procedimiento_almacenado($valor)";
            $stm = $conexion->query($sql);
            if (!$stm) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo "No se pudo pudieron obtener los datos Error" . $ex->getMessage();
        }
    }
}


