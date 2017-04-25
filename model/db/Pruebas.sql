/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Syscom
 * Created: 06-mar-2017
 */




SELECT * FROM v_lista_factura_ventas WHERE CAST(fecha_venta AS DATE) = '2016-09-13' 













/*********************MENUS********************************/
SELECT opcion,contenido FROM tb_menu mn
inner join tb_accesos ac on ac._id_menu=mn.id_menu
    join tb_grupos gr on gr.id_grupo=mn._id_grupo
    join tb_roles r on r.id_rol=ac._id_rol
    join tb_usuarios_roles ur on ur._id_rol=r.id_rol
    join tb_usuarios u on u.id_usuario=ur._id_usuario
where (id_usuario='admin')

SELECT id_grupo,grupo FROM tb_grupos gr
inner join tb_menu mn on gr.id_grupo=mn._id_grupo
join tb_accesos ac on ac._id_menu=mn.id_menu
join tb_roles r on r.id_rol=ac._id_rol
join tb_usuarios_roles ur on ur._id_rol=r.id_rol
join tb_usuarios u on u.id_usuario=ur._id_usuario
where (id_usuario='admin')




/****CONSULTA USUARIO Y ROL***/
SELECT u.id_usuario,passw,concat_ws(' ', nombres, apellidos) as fullname,
    r.id_rol, r.rol
    FROM tb_empleados e
        JOIN tb_usuarios u ON e.id_empleado = u.id_usuario
        JOIN tb_usuarios_roles ur ON u.id_usuario = ur._id_usuario
        JOIN tb_roles r ON ur._id_rol = r.id_rol
    WHERE (u.id_usuario = 'admin'  AND u.estado = 'A');


/*------------- PARA MOSTRAR EN EL MENU -------------------*/

SELECT g.grupo, mn.opcion, mn.contenido, mn.imagen
FROM tb_accesos ac 
    JOIN tb_menu mn ON ac._id_menu = mn.id_menu
    JOIN tb_grupos g ON mn._id_grupo = g.id_grupo
WHERE ac._id_rol = 1
ORDER BY grupo, mn.orden

/*MUESTRA USUARIO Y ROL*/

SELECT u.id_usuario,concat_ws(' ', nombres, apellidos) as fullname,
    r.id_rol, r.rol
    FROM tb_empleados e
        JOIN tb_usuarios u ON e.id_empleado = u.id_usuario
        JOIN tb_usuarios_roles ur ON u.id_usuario = ur._id_usuario
        JOIN tb_roles r ON ur._id_rol = r.id_rol
    WHERE (u.id_usuario = 'admin'  AND u.estado = 'A');
/*---------------------------------------------------------------*/

SELECT a.id_acceso,m.opcion,rol
    FROM tb_accesos a
        JOIN tb_menu m ON m.id_menu = a._id_menu
        JOIN tb_roles r ON r.id_rol = a._id_rol

        JOIN tb_roles r ON ur._id_rol = r.id_rol
  
  WHERE (u.id_usuario = 'admin'  AND u.estado = 'A');
/*-------------------------para ver los grupos que opciones tienes */

SELECT r.rol,gr.id_grupo, gr.grupo, id_menu,opcion,contenido,mn.estado 
    from tb_menu mn
        join tb_grupos gr on gr.id_grupo= mn._id_grupo
        join tb_accesos ac on ac._id_menu= mn.id_menu
        join tb_roles r on r.id_rol=ac._id_rol

/**************** CAMBIAR ESTADO  MARCA ***********************/

DROP PROCEDURE  IF EXISTS sp_update_estado_tb_marca;
DELIMITER //
create procedure sp_update_estado_tb_marca(
    n_id_marca int(11))
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    declare estado_act char(1);
select estado into estado_act from tb_marcas where id_marca=n_id_marca;
if estado_act='a' then
    update tb_marcas SET estado='D' where id_marca=n_id_marca;
else 
    update tb_marcas SET estado='A' where id_marca=n_id_marca;
end if;
END//
DELIMITER ;

SELECT id_factura, fecha_venta FROM tb_factura_ventas WHERE Month(fecha_venta)=9


































/*---------------------------------------------------------------------SOLO PREUBAS */


SELECT
tb_factura_compras.id_factura,
tb_factura_compras.fecha_compra,
tb_detalle_compras.id_compras,
tb_detalle_compras._id_producto,
tb_detalle_compras.stok,
tb_detalle_compras.valor_venta
FROM
tb_factura_compras
INNER JOIN tb_detalle_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura
WHERE tb_factura_compras.fecha_compra=(SELECT MIN(tb_factura_compras.fecha_compra) FROM tb_factura_compras)




SELECT 
    tb_factura_compras.id_factura, 
    tb_factura_compras.fecha_compra,
    tb_detalle_compras.id_compras,
    tb_detalle_compras._id_producto, 
    tb_detalle_compras.stok, 
    tb_detalle_compras.valor_venta 
FROM 
    tb_factura_compras 
INNER JOIN tb_detalle_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura 
WHERE tb_detalle_compras._id_producto  IN ( SELECT DISTINCT
tb_detalle_compras._id_producto
FROM
tb_detalle_compras
INNER JOIN tb_factura_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura
WHERE tb_factura_compras.fecha_compra = (select min(tb_factura_compras.fecha_compra) from tb_factura_compras)
)
ORDER BY tb_factura_compras.fecha_compra ASC 

/*--------------------para pasar a Mayusculas la primera Letra----------*/

UPDATE tb_categorias SET nombres = CONCAT(UPPER(LEFT(nombres,1)),LOWER(SUBSTRING(nombres,2)));
UPDATE tb_marcas SET nombre = CONCAT(UPPER(LEFT(nombre,1)),LOWER(SUBSTRING(nombre,2)));
UPDATE tb_productos SET nombres = CONCAT(UPPER(LEFT(nombres,1)),LOWER(SUBSTRING(nombres,2)));
update tb_detalle_compras set estado='1'; 


DROP PROCEDURE `sp_update_grupos`; 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_grupos`
(IN `_id_grupo` INT, IN `_grupo` TEXT, IN `_imagen` VARCHAR(75))
 NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER 
begin 
    update tb_grupos 
    set grupo=_grupo, imagen=_imagen 
    WHERE id_grupo=_id_grupo; 
END 