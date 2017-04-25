CREATE OR REPLACE VIEW v_factura_cliente as(
    SELECT nombres,cedula,telefono,direccion,id_factura,_id_cliente FROM tb_clientes
    LEFT JOIN tb_factura_ventas ON tb_clientes.id_cliente = tb_factura_ventas._id_cliente);

CREATE OR REPLACE VIEW v_producto_marca_categoria as(
    SELECT        
        tb_productos.id_producto,
        tb_productos.codigo_barras,
        tb_categorias.id_categoria as id_c,
        tb_categorias.nombres as categoria,        
        tb_productos.nombres as producto,
        tb_marcas.id_marca as id_m,
        tb_marcas.nombre as marca
    FROM
    tb_categorias
    Inner Join tb_productos ON tb_productos._id_categoria = tb_categorias.id_categoria
    Inner Join tb_marcas ON tb_productos._id_marca = tb_marcas.id_marca);


CREATE OR REPLACE VIEW v_empleado_usuario as(
SELECT ur.id_usuario_rol, u.id_usuario,concat_ws(' ', nombres, apellidos) as usuario,
                    r.id_rol, r.rol,e.estado
    FROM tb_empleados e
        JOIN tb_usuarios u ON e.id_empleado = u.id_usuario
        JOIN tb_usuarios_roles ur ON u.id_usuario = ur._id_usuario
        JOIN tb_roles r ON ur._id_rol = r.id_rol);


CREATE  OR REPLACE VIEW v_factura_compras_abiertas AS(
SELECT
    tb_proveedores.ruc,
    tb_proveedores.nombres,
    tb_factura_compras.id_factura,
    tb_factura_compras.fecha_compra,
    tb_empleados.id_empleado,
    concat_ws(' ', tb_empleados.nombres, tb_empleados.apellidos) as fullname
FROM
tb_factura_compras
Inner Join tb_proveedores ON tb_factura_compras._ruc = tb_proveedores.ruc
Inner Join tb_empleados ON tb_factura_compras._id_empleado = tb_empleados.id_empleado
WHERE tb_factura_compras.estado =  'A') ;


CREATE  OR REPLACE VIEW v_productos AS 
(SELECT
        tb_productos.id_producto, 
        tb_productos.codigo_barras,
        concat_ws(' ', tb_categorias.nombres, tb_productos.nombres, tb_marcas.nombre) as productos,
        tb_productos.descripcion,
        tb_productos.imagen
FROM
    tb_productos
    Inner Join tb_marcas ON tb_productos._id_marca = tb_marcas.id_marca
    Inner Join tb_categorias ON tb_productos._id_categoria = tb_categorias.id_categoria);


CREATE  OR REPLACE VIEW v_detalle_factura_compras AS 
(SELECT
    tb_detalle_compras.id_compras as id,
    tb_detalle_compras.cantidad as cantidad,
    concat_ws(' ', tb_categorias.nombres, tb_productos.nombres, tb_marcas.nombre) as productos,
    tb_factura_compras._id_empleado,
    tb_factura_compras.id_factura,    
    tb_detalle_compras.valor_compra,
    tb_detalle_compras.valor_real_compra,    
    tb_detalle_compras.descuento,
    tb_detalle_compras.valor_venta,
    tb_detalle_compras.estado
FROM
    tb_detalle_compras
    Inner Join tb_productos ON tb_detalle_compras._id_producto = tb_productos.id_producto
    Inner Join tb_marcas ON tb_marcas.id_marca = tb_productos._id_marca AND tb_productos._id_marca = tb_marcas.id_marca
    Inner Join tb_categorias ON tb_productos._id_categoria = tb_categorias.id_categoria
    Inner Join tb_factura_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura
);

/*-----------------facturas de venta activas-------------------------*/
CREATE  OR REPLACE VIEW v_facturas_ventas_activas AS (   
SELECT
    tb_clientes.nombres,
    tb_clientes.cedula,
    tb_clientes.id_cliente,
    tb_clientes.telefono,
    tb_clientes.direccion,
    tb_factura_ventas.fecha_venta,
    tb_factura_ventas._id_empleado,
    tb_factura_ventas.id_factura,
    tb_factura_ventas.estado
FROM
    tb_factura_ventas
    INNER JOIN tb_clientes ON tb_factura_ventas._id_cliente = tb_clientes.id_cliente 
    );

/*-----vista productos disponibles para venta------*/

CREATE  OR REPLACE VIEW v_productos_disponibles AS 
(SELECT
    concat_ws(' ', tb_categorias.nombres, tb_productos.nombres,tb_marcas.nombre) as producto,
    tb_productos.codigo_barras,    
    tb_detalle_compras.valor_venta,
    tb_detalle_compras.stok,
    tb_categorias.id_categoria,
    tb_productos.id_producto,
    tb_marcas.id_marca,    
    tb_factura_compras.id_factura
    
FROM
    tb_marcas
INNER JOIN tb_productos ON tb_productos._id_marca = tb_marcas.id_marca
INNER JOIN tb_categorias ON tb_productos._id_categoria = tb_categorias.id_categoria
INNER JOIN tb_detalle_compras ON tb_detalle_compras._id_producto = tb_productos.id_producto
INNER JOIN tb_factura_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura
where tb_detalle_compras.stok >0
group by tb_detalle_compras._id_producto
) ;

/*---------TODOS LOS PRODUCTOS DE DIFERENTES FACTURAS */
CREATE  OR REPLACE VIEW v_productos_disponibles_venta AS 
( SELECT
    concat_ws(' ', tb_categorias.nombres , tb_productos.nombres,tb_marcas.nombre) as producto,
    tb_productos.codigo_barras,    
    tb_detalle_compras.valor_venta,
    tb_detalle_compras.stok,
    tb_categorias.id_categoria,
    tb_productos.id_producto,
    tb_marcas.id_marca,    
    tb_factura_compras.id_factura,
    tb_factura_compras.fecha_compra,
    tb_detalle_compras.id_compras    
FROM
    tb_marcas
INNER JOIN tb_productos ON tb_productos._id_marca = tb_marcas.id_marca
INNER JOIN tb_categorias ON tb_productos._id_categoria = tb_categorias.id_categoria
INNER JOIN tb_detalle_compras ON tb_detalle_compras._id_producto = tb_productos.id_producto
INNER JOIN tb_factura_compras ON tb_detalle_compras._id_factura = tb_factura_compras.id_factura
where tb_detalle_compras.stok >0 and (SELECT min(fecha_compra) FROM tb_factura_compras)  
order by tb_factura_compras.fecha_compra
);

/*----MUESTRA DETALLES DE FACTURA DE VENTAS --------------*/

CREATE  OR REPLACE VIEW v_detalle_factura_venta AS 
( SELECT
    tb_detalle_ventas.id_ventas,
    tb_detalle_ventas.cantidad,
    concat_ws(' ', tb_categorias.nombres , tb_productos.nombres,tb_marcas.nombre) as producto,
    tb_detalle_ventas.precio_venta,
    descuento,
    tb_factura_ventas._id_empleado,
    tb_factura_ventas.id_factura,
    tb_factura_ventas.estado
FROM
    tb_detalle_ventas
    INNER JOIN tb_productos ON tb_detalle_ventas._id_producto = tb_productos.id_producto
    INNER JOIN tb_marcas ON tb_productos._id_marca = tb_marcas.id_marca
    INNER JOIN tb_categorias ON tb_productos._id_categoria = tb_categorias.id_categoria
    INNER JOIN tb_factura_ventas ON tb_detalle_ventas._id_factura = tb_factura_ventas.id_factura
);

/*-------------------FACTURAS ACTIVAS ------------------------------------*/

CREATE OR REPLACE VIEW v_lista_factura_ventas AS 
(SELECT
    tv.id_factura,
    tv.fecha_venta,
    tv.estado,
    tc.id_cliente,
    tc.nombres,
    te.id_empleado,
    concat_ws (' ',te.nombres, te.apellidos ) as empleado,
    Sum(tdv.precio_venta*tdv.cantidad) as total,
    Sum(tdv.precio_venta*tdv.cantidad*tdv.descuento) as descuento
FROM
    tb_factura_ventas AS tv
    INNER JOIN tb_clientes AS tc ON tv._id_cliente = tc.id_cliente
    INNER JOIN tb_empleados AS te ON tv._id_empleado = te.id_empleado
    INNER JOIN tb_detalle_ventas AS tdv ON tdv._id_factura = tv.id_factura
    GROUP BY
    tv.id_factura);

CREATE OR REPLACE VIEW v_lista_factura_compras AS 
(SELECT
    tc.id_factura,
    tc.fecha_compra,
    tc.estado,
    tpr.ruc,
    tpr.nombres,
    te.id_empleado,
    concat_ws (' ',te.nombres, te.apellidos ) as empleado,
    SUM(tdc.valor_real_compra*tdc.cantidad) as total,
    SUM(tdc.valor_compra*tdc.descuento) as Descuento
FROM
    tb_factura_compras AS tc
INNER JOIN tb_proveedores AS tpr ON tc._ruc = tpr.ruc
INNER JOIN tb_empleados AS te ON tc._id_empleado = te.id_empleado
INNER JOIN tb_detalle_compras as tdc ON tdc._id_factura=tc.id_factura
GROUP BY 
tc.id_factura
);

CREATE OR REPLACE VIEW v_seguridad_resumen AS 
(SELECT
    tb_accesos.id_acceso,
    tb_roles.id_rol,
    tb_roles.rol,
    tb_menu.id_menu,
    tb_menu.opcion,
    tb_menu.contenido,
    tb_grupos.id_grupo,
    tb_grupos.grupo

FROM
    tb_accesos
    INNER JOIN tb_roles ON tb_accesos._id_rol = tb_roles.id_rol
    INNER JOIN tb_menu ON tb_accesos._id_menu = tb_menu.id_menu
    INNER JOIN tb_grupos ON tb_menu._id_grupo = tb_grupos.id_grupo);

CREATE OR REPLACE VIEW v_detalle_factura_compras_stok AS(
SELECT
        tdc.id_compras,
        tdc.cantidad,
        tdc.stok,
        tp.codigo_barras,
        concat_ws(' ', tc.nombres, tp.nombres, tm.nombre) AS productos,
        tdc.valor_real_compra,
        tdc.valor_venta,
        tdc.modificado,
        tdc.estado
FROM
     tb_detalle_compras AS tdc
    INNER JOIN tb_productos AS tp ON tdc._id_producto = tp.id_producto
    INNER JOIN tb_categorias AS tc ON tp._id_categoria = tc.id_categoria
    INNER JOIN tb_marcas AS tm ON tp._id_marca = tm.id_marca);

CREATE OR REPLACE VIEW v_venta_total_por_categoria AS(
    SELECT
        tfv.id_factura,
        Sum(tdv.cantidad) AS cantidad,
        Sum(tdv.precio_venta*tdv.cantidad) AS total,
        Sum(tdv.precio_venta*tdv.cantidad*tdv.descuento) AS descuento,
        tc.nombres,
        tfv.fecha_venta,
        tdv.estado,
        te.id_empleado
    FROM
        tb_factura_ventas AS tfv
    INNER JOIN tb_detalle_ventas AS tdv ON tdv._id_factura = tfv.id_factura
    INNER JOIN tb_productos ON tdv._id_producto = tb_productos.id_producto
    INNER JOIN tb_categorias AS tc ON tb_productos._id_categoria = tc.id_categoria
    INNER JOIN tb_empleados AS te ON tfv._id_empleado = te.id_empleado

    GROUP BY                        
        tc.nombres,
        tfv.fecha_venta);