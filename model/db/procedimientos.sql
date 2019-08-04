/*  ESTADOS 
________________________________
|    FACTURAS   |  APLICACION   |
--------------------------------
| Cerrado=0;    |   Activo=A;   |
| Abierto=1;    |   Desact=D;   |
| Pentiente=2;  |               |
| Pagado=3      |               |
---------------------------------

Estandar: 
********************************************************************************
Los procedimientos se crearan asi pa_nombre_procedimiento
********************************************************************************
*/

DROP PROCEDURE IF EXISTS pa_crear_grupos;
DROP PROCEDURE IF EXISTS pa_actualizar_grupos;
DROP PROCEDURE IF EXISTS pa_eliminar_grupos;
DROP PROCEDURE IF EXISTS pa_actualizar_estado_grupos;
DROP PROCEDURE IF EXISTS pa_actualizar_estado_menu;
DROP PROCEDURE IF EXISTS pa_crear_empleado;
DROP PROCEDURE IF EXISTS pa_actualizar_empleado;
DROP PROCEDURE IF EXISTS pa_crear_cliente;
DROP PROCEDURE IF EXISTS pa_actualizar_cliente;
DROP PROCEDURE IF EXISTS pa_eliminar_cliente;
DROP PROCEDURE IF EXISTS pa_crear_categoria;
DROP PROCEDURE IF EXISTS pa_actualizar_categoria;
DROP PROCEDURE IF EXISTS pa_eliminar_categoria;
DROP PROCEDURE IF EXISTS pa_crear_marca;
DROP PROCEDURE IF EXISTS pa_actualizar_estado_marca;
DROP PROCEDURE IF EXISTS pa_crear_factura_ventas;
DROP PROCEDURE IF EXISTS pa_crear_factura_detalle_ventas;
DROP PROCEDURE IF EXISTS pa_actualizar_factura_detalle_ventas;
DROP PROCEDURE IF EXISTS pa_cerrar_factura_ventas;
DROP PROCEDURE IF EXISTS pa_actualizar_stok;
DROP PROCEDURE IF EXISTS pa_actualizar_estado_factura_ventas;
DROP PROCEDURE IF EXISTS pa_eliminar_factura_detalle_ventas;
DROP PROCEDURE IF EXISTS pa_crear_factura_detalle_compras;
DROP PROCEDURE IF EXISTS pa_cerrar_factura_compras;
DROP PROCEDURE IF EXISTS pa_actualizar_factura_detalle_compras;
DROP PROCEDURE IF EXISTS pa_eliminar_factura_detalle_compras;
DROP PROCEDURE IF EXISTS pa_crear_factura_compras;
DROP PROCEDURE IF EXISTS pa_crear_proveedores;
DROP PROCEDURE IF EXISTS pa_actualizar_proveedor;
DROP PROCEDURE IF EXISTS pa_eliminar_proveedor;
DROP PROCEDURE IF EXISTS pa_crear_empresa;
DROP PROCEDURE IF EXISTS pa_actualizar_estado_empleado;

DELIMITER $$

/*---------------- CREA EMPRESA ------------------*/
create procedure pa_crear_empresa(
    _nombre varchar(100),
    _descripcion varchar(100),
    _propietario varchar(200),
    _direccion varchar(200),
    _logo varchar(200),
    _slogan varchar(300)   
)
Begin
    insert into tb_empresa(nombre,descripcion,propietario,direccion,logo,slogan)
                values(_nombre,_descripcion,_propietario,_direccion,_logo,_slogan);
end$$

/*              CREAR PROVEHEDORERS       */
CREATE PROCEDURE pa_crear_proveedores (        
    _ruc varchar(15),    
    _nombres varchar(30),   
    _correo varchar(30),    
    _telefono varchar(10),
    _direccion varchar(50)
)
Begin
    IF NOT EXISTS (SELECT ruc FROM tb_proveedores WHERE ruc=_ruc) then
        INSERT into tb_proveedores(ruc, nombres ,correo, telefono,direccion)    
        values(_ruc,_nombres,_correo,_telefono,_direccion);
    else 
        select 'Proveedor Registrado';
    End if;
END$$

/*-------------------- ACTUALIZAR PROVEEDORES----------------------------*/

CREATE PROCEDURE pa_actualizar_proveedor (        
    _ruc varchar(15),    
    _nombres varchar(30),   
    _correo varchar(30),    
    _telefono varchar(10),
    _direccion varchar(50)
)
Begin    
    update tb_proveedores
    set nombres=_nombres ,correo=_correo, telefono=_telefono,direccion= _direccion 
    WHERE ruc=_ruc;  
END$$


/************elimina proveedor ********************/


create procedure pa_eliminar_proveedor(_ruc varchar(15)) 
    begin   
        DELETE FROM tb_proveedores WHERE ruc=_ruc;
    END$$


/*-------------------- CREA GRUPOS----------------------------*/
create procedure pa_crear_grupos(    
        _grupo text,
        _imagen varchar(75))    
    begin   
        IF NOT EXISTS ( SELECT grupo FROM tb_grupos WHERE grupo = _grupo) THEN
            Insert Into tb_grupos(grupo, imagen)
            VALUES ( _grupo,_imagen);
            ELSE
            SELECT 'Este cliente ya existe en la base de datos!';
        END IF;
    END$$
/*-------------------- ACTUALIZA GRUPOS----------------------------*/
create procedure pa_actualizar_grupos(
        _id_grupo int,	
        _grupo text,
        _imagen varchar(75))    
    begin   
        update tb_grupos
        set grupo=_grupo, imagen=_imagen
        WHERE id_grupo=_id_grupo;
    END$$
/*-------------------- ELIMINA GRUPOS----------------------------*/
create procedure pa_eliminar_grupos(_id_grupo int) 
    begin   
        DELETE FROM tb_grupos WHERE id_grupo=_id_grupo;
    END$$

/*-------------------- ACTUALIZA ESTADO GRUPOS----------------------------*/
create procedure pa_actualizar_estado_grupos(
        _id_grupo int 
    )    
    begin  
        declare estado_act char(1);
        select estado into estado_act from tb_grupos where id_grupo=_id_grupo;
        if estado_act='A' then
            update tb_grupos SET estado='D' where id_grupo=_id_grupo;
        else 
            update tb_grupos SET estado='A' where id_grupo=_id_grupo;
        end if;
    END$$
/*=============  G R U P O S    P A G =   3 ===================*/
/*-------------------- ACTUALIZA ESTADO MENU----------------------------*/
create procedure pa_actualizar_estado_menu(
        _id_menu int(11) 
    )    
    begin  
        declare estado_act char(1);
        select estado into estado_act from tb_menu where id_menu=_id_menu;
        if estado_act='A' then
            update tb_menu SET estado='D' where id_menu=_id_menu;
        else 
            update tb_menu SET estado='A' where id_menu=_id_menu;
        end if;
    END$$
/*-------------------- CREA EMPLEADO--------------------------*/
create procedure pa_crear_empleado(
    _id_empleado varchar(15),/*cedula*/
    _nombres varchar(30),
    _apellidos varchar(30),
    _nacimiento date,
    _sexo char(1),
    _correo varchar(30),
    _nacionalidad varchar(30),
    _telefono varchar(10) ,
    _direccion varchar(50) ,
    _foto varchar(100)
)    
begin   
    IF NOT EXISTS ( SELECT C.nombres
        FROM tb_empleados AS e 
        WHERE e.id_empleado = _id_empleado) THEN
        Insert Into tb_empleados(id_empleado, nombres,apellidos,nacimiento,sexo,correo,nacionalidad,telefono,direccion,foto)
        VALUES (_id_empleado, _nombres,_apellidos,_nacimiento,_sexo,_correo,_nacionalidad,_telefono,_direccion,_foto);
        ELSE
        SELECT 'Este cliente ya existe en la base de datos!';
    END IF;
END$$
/*-------------------- ACTUALIZA EMPLEADO----------------------------*/
create procedure pa_actualizar_empleado(
    _cedula varchar(15),
    _nombres varchar(30),   
    _apellidos varchar(30), 
    _nacimiento date,
    _sexo char(1),    
    _correo varchar(30),   
    _nacionalidad varchar(30),
    _telefono varchar(10) ,
    _direccion varchar(50),
    _foto varchar(50)
)    
begin   
    update tb_empleados
    set nombres=_nombres, apellidos=_apellidos, nacimiento=_nacimiento,
        sexo=_sexo, correo=_correo, nacionalidad=_nacionalidad,telefono=_telefono,
        direccion=_direccion,foto=_foto
    WHERE id_empleado=_cedula;
END$$
/*-------------------- ACTUALIZAR ESTADO EMPLEADO----------------------------*/
create procedure pa_actualizar_estado_empleado(
    _cedula varchar(15)
)    
begin   
        declare estado_actual char(1);
        select estado into estado_actual from tb_empleados where id_empleado=_cedula;
        if estado_actual='A' then
            update tb_empleados SET estado='D' where id_empleado=_cedula;
        else 
            update tb_empleados SET estado='A' where id_empleado=_cedula;
        end if;
END$$
/*-------------------- INGRESA CLIENTE----------------------------*/
create procedure pa_crear_cliente(
    _nombres varchar(100),    
    _cedula varchar(30),    
    _correo varchar(30) ,   
    _telefono varchar(10) ,
    _direccion varchar(50))
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    IF NOT EXISTS ( SELECT C.cedula
        FROM tb_clientes 
        WHERE cedula = _cedula) THEN
        Insert Into tb_clientes(nombres, cedula, correo, telefono, direccion)
        VALUES (_nombres,_cedula,_correo,_telefono,_direccion);
        ELSE
        SELECT 'Este cliente ya existe en la base de datos!';
    END IF;
END$$
/*-------------------- ACTUALIZAR CLIENTE----------------------------*/
create procedure pa_actualizar_cliente(
    _id_cliente int(11),
    _nombres varchar(100),    
    _cedula varchar(30),    
    _correo varchar(30) ,   
    _telefono varchar(10) ,
    _direccion varchar(50))    
begin
    update tb_clientes
       SET nombres=_nombres, cedula=_cedula, correo=_correo, telefono=_telefono, 
                direccion=_direccion
       WHERE id_cliente = _id_cliente;
END$$

/*------------ ELIMINAR CLIENTES----------------------------------*/
CREATE PROCEDURE pa_eliminar_cliente(_id_cliente INT(11)) 
BEGIN     
    delete from tb_clientes where id_cliente=_id_cliente;
END$$

/*==================== CREAR CATEGORIA ==========================*/

create procedure pa_crear_categoria(
    nombres varchar(30),    
    descripcion varchar(50))
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    IF NOT EXISTS ( SELECT C.nombres
        FROM tb_categorias AS C 
        WHERE C.nombres = nombres) THEN
        Insert Into tb_categorias(nombres, descripcion)
        VALUES ( nombres,descripcion);
        ELSE
        SELECT 'Este cliente ya existe en la base de datos!';
    END IF;
END$$

/*------------ ACTUALIZAR CATEGORIA----------------------------*/
CREATE PROCEDURE pa_actualizar_categoria
    (id_c int(11),_nombre varchar(20), _descripcion varchar(50)) 
BEGIN
    update tb_categorias 
            set nombres= _nombre, descripcion=_descripcion                 
            WHERE id_categoria=id_c;
END$$

/*------------ ELIMINAR CATEGORIA----------------------------------*/
CREATE PROCEDURE pa_eliminar_categoria(IN id_cat INT(11)) 
BEGIN 
    delete from tb_categorias where id_categoria=id_cat;
END$$
/*==================== CREAR MARCAS ==========================*/
create procedure pa_crear_marca(
    nombre varchar(50),    
    descripcion varchar(100))
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    IF NOT EXISTS ( SELECT M.nombre
        FROM tb_marcas AS M
        WHERE M.nombre = nombre) THEN
        Insert Into tb_marcas(nombre, descripcion)
        VALUES ( nombre,descripcion);
    ELSE
        SELECT 'Este cliente ya existe en la base de datos!';
    END IF;
END$$
/*------------ ACTUALIZAR ESTADO MARCA----------------------------------*/
create procedure pa_actualizar_estado_marca(
        _id_marca int 
    )    
    begin  
        declare estado_marca_actual char(1);
        select estado into estado_marca_actual from tb_marcas where id_marca=_id_marca;
        if estado_marca_actual='A' then
            update tb_marcas SET estado='D' where id_marca=_id_marca;
        else 
            update tb_marcas SET estado='A' where id_marca=_id_marca;
        end if;
    END$$
/*------------------========********CREAR FACTURAS VENTAS *********========---------------*/
CREATE PROCEDURE pa_crear_factura_ventas(
    _id_c INT(11), 
    _id_u VARCHAR(15))
BEGIN 
    insert into tb_factura_ventas(_id_cliente,_id_empleado) 
                           values(_id_c,_id_u);     
END$$
/*----------- AGREGA PRODUCTOS A FACTURA  DETALLE VENTAS --------------*/
create procedure pa_crear_factura_detalle_ventas
(
    num_factura int(11),
    producto int(11),
    cantidad float,
    precio_venta float
)
begin
    declare numeroProductosEnFactura int;
    SELECT COUNT(*) into numeroProductosEnFactura  FROM tb_detalle_ventas WHERE tb_detalle_ventas._id_factura=num_factura;

    if numeroProductosEnFactura<17 then
        insert into tb_detalle_ventas(id_ventas,_id_factura,_id_producto,cantidad,precio_venta) 
                           values(numeroProductosEnFactura+1,num_factura,producto,cantidad,precio_venta);
    else 
        SELECT 'No se puede agregar mas productos a la factura!';
    end if;  
END$$
/*-------------------- ACTUALIZA DETALLE FACTURA VENTAS-----------------------*/
create procedure pa_actualizar_factura_detalle_ventas(
    n_id_ventas int(11), n_id_factura int(11),
    n_cantidad float, n_precio_venta float, n_descuento float)
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    update tb_detalle_ventas
        set cantidad= n_cantidad, precio_venta=n_precio_venta, descuento=n_descuento                  
        WHERE id_ventas=n_id_ventas and _id_factura= n_id_factura;
END$$
/*-------------------- CIERRA FACTURA VENTAS----------------------------*/
create procedure pa_cerrar_factura_ventas(
    n_id_factura int(11), n_id_empleado varchar(15),
    n_estado char(1))
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
begin
    update tb_factura_ventas
        set estado= n_estado
        WHERE id_factura=n_id_factura and _id_empleado= n_id_empleado;
END$$
/*************** ELIMINA PRODUNTO DE LA TABLA FACTURA VENTAS ******************/
create procedure pa_eliminar_factura_detalle_ventas
(
    n_id_ventas int(11),
    n_id_factura int(11)
)
    COMMENT 'Procedimiento para eliminar dato de tb_detalle_ventas'
BEGIN
   delete FROM tb_detalle_ventas                
            WHERE id_ventas = n_id_ventas and _id_factura = n_id_factura;
END$$
/*----------------- CREAR FACTURA DETALLE COMPRAS  ----------------------*/
CREATE PROCEDURE pa_crear_factura_detalle_compras(
    num_factura varchar(20),
    producto int(11),
    cantidad float,
    valor_compra float, 
    valor_real_compra float,
    stok float, 
    descuento float, 
    valor_venta float
) 
BEGIN
    insert into tb_detalle_compras(_id_factura,_id_producto,cantidad,
                valor_compra,valor_real_compra,stok,descuento,valor_venta) 
    values(num_factura,producto,cantidad,valor_compra,
            valor_real_compra,stok,descuento,valor_venta);
END$$
/*----------------- CERRAR LA FACTURA ----------------------*/
CREATE PROCEDURE pa_cerrar_factura_compras
    (id_factura_ varchar(20),estado_ char(1)) 
BEGIN
    update tb_factura_compras 
            set estado= estado_ 
            WHERE id_factura=id_factura_;
END$$
/*------------ ACTUALIZAR FACTURA DETALLE COMPRAS----------------------------*/
CREATE PROCEDURE pa_actualizar_factura_detalle_compras
    (id_t int(11),cant float, valor_comp float, valor_real_comp float,
     stok_act float, descuento_act float, valor_venta_act float)
BEGIN
    update tb_detalle_compras 
            set cantidad= cant, valor_compra=valor_comp,
                valor_real_compra=valor_real_comp,stok=stok_act,
                descuento=descuento_act,valor_venta=valor_venta_act                  
            WHERE id_compras=id_t;
END$$
/*------------ ELIMINAR FACTURA DETALLE COMPRAS----------------------------------*/
CREATE PROCEDURE pa_eliminar_factura_detalle_compras(id_t int(11)) 
BEGIN
    delete FROM tb_detalle_compras                
            WHERE id_compras=id_t;
END$$


/*empleados con equipos en mantenimiento a su cargo*/
/*------------- ACTUALIZAR STOK DE PRODUCTOR -----------*/
CREATE PROCEDURE pa_actualizar_stok
(   n_id_transacion int(11), 
    n_stock float, 
    n_factura varchar(20)
) 
    COMMENT 'Procedimiento para eliminar dato de tb_detalle_ventas'
BEGIN
   update tb_detalle_compras SET stok= n_stock
    WHERE id_compras=n_id_transacion and _id_factura=n_factura;
END$$

/*ACTUALIA ESTADO DE FACTURA CERRADO=0; ABIERTO=1; PENDIENTE=2; PAGADO=3*/
create procedure pa_actualizar_estado_factura_ventas(
    n_id_factura int(11),
    n_estado char(1)
)
    COMMENT 'Procedimiento que inserta un cliente a la base de datos'
BEGIN
    declare estado_act char(1);
    select estado into estado_act from tb_factura_ventas where id_factura=n_id_factura;
    if estado_act='0' OR estado_act='2' then
        update tb_factura_ventas SET estado='1' where id_factura=n_id_factura;    
    end if;
END$$
/*------------------========********CREAR FACTURAS COMPRAS*********========---------------*/
CREATE PROCEDURE pa_crear_factura_compras(
    _id_clienta varchar(20),num_factura varchar(20),
    usuario VARCHAR(15), f_compra date
) 
BEGIN
    insert into tb_factura_compras(_ruc,id_factura,_id_empleado,fecha_compra) 
                           values(ruc,num_factura,usuario,f_compra);
END$$