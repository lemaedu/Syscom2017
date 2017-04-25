
CREATE database db_syscomandes;

use db_syscomandes;

create table empresa(
    nombre varchar(100),
    descripcion varchar(100),
    propietario varchar(200),
    direccion varchar(200),
    logo varchar(200),
    slogan varchar(300),
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,    
    estado char(1) NOT NULL DEFAULT 'A'
);

CREATE TABLE tb_empleados (    
    id_empleado varchar(15) primary key,/*cedula*/
    nombres varchar(30),
    apellidos varchar(30),
    nacimiento date,
    sexo char(1) default 'M',
    correo varchar(30) default '',
    nacionalidad varchar(30)default '',
    telefono varchar(10) default '',
    direccion varchar(50) default '',
    foto varchar(100),
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A' /* A=activo , X = Desactivado*/
);


CREATE TABLE tb_usuarios (    
    id_usuario varchar(15) primary key,/*cedula*/
    passw varchar(32),    
    estado char(1) default 'A', /* A=activo , X = Desactivado*/
    index empleado_usuario(id_usuario),
    constraint FOREIGN KEY(id_usuario) REFERENCES tb_empleados (id_empleado)
);

CREATE TABLE tb_grupos(
    id_grupo int not null auto_increment primary key,	
    grupo text NOT NULL,
    imagen varchar(75),
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,    
    estado char(1) NOT NULL DEFAULT 'A'
);

CREATE TABLE tb_menu(
    id_menu int not null auto_increment primary key,	
    _id_grupo integer NOT NULL,
    opcion varchar(50) NOT NULL,
    contenido varchar(50) DEFAULT '',
    orden integer,    
    estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(_id_grupo) REFERENCES tb_grupos (id_grupo)
);

CREATE TABLE tb_roles(
    id_rol int not null auto_increment primary key,
    rol text NOT NULL,
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,    
    estado char(1) NOT NULL DEFAULT 'A'
);

CREATE TABLE tb_usuarios_roles (
    id_usuario_rol int not null auto_increment PRIMARY KEY,  
    _id_rol integer NOT NULL,
    _id_usuario varchar(15) NOT NULL,
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,    
    estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(_id_usuario) REFERENCES tb_usuarios (id_usuario),
    FOREIGN KEY(_id_rol) REFERENCES tb_roles (id_rol)
);

CREATE TABLE tb_accesos(
	id_acceso int not null auto_increment PRIMARY KEY,
	_id_menu integer NOT NULL,
	_id_rol integer NOT NULL,
	registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,	
	estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(_id_menu) REFERENCES tb_menu (id_menu),
	FOREIGN KEY(_id_rol) REFERENCES tb_roles (id_rol)
);

/*------------------------------------------------------------------------------------------*/
/*--------------------------TABLA DE PRODUCTOS-------------------------------*/
create table tb_marcas(
    id_marca int(11) NOT NULL AUTO_INCREMENT primary key,
    nombre varchar(50),
    descripcion varchar(100), 
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A' /* A=activo , X = Desactivado*/
);

CREATE TABLE tb_categorias (    
    id_categoria int(11) NOT NULL AUTO_INCREMENT primary key,    
    nombres varchar(30),            
    descripcion varchar(50) default '',
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A' /* A=activo , X = Desactivado*/
);

CREATE TABLE tb_productos (   
    id_producto int(11) NOT NULL AUTO_INCREMENT primary key,   
    codigo_barras varchar(30), 
    nombres varchar(30),
    _id_categoria int(11) ,        
    _id_marca int(11),
    descripcion varchar(50) default '',
    imagen varchar(100) default '',
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A',/* A=activo , X = Desactivado*/
    constraint FOREIGN KEY(_id_categoria) REFERENCES tb_categorias (id_categoria),
    constraint FOREIGN KEY(_id_marca) REFERENCES tb_marcas (id_marca)
);

/*---------------------------------FIN TABLA PRODUCTOS ------------------------*/
/*------------------------------------TABLA PARA OPERACIONES ------------------*/
CREATE TABLE tb_proveedores (        
    ruc varchar(15) primary key,    
    nombres varchar(30),    
    correo varchar(30) default '',    
    telefono varchar(10) default '',
    direccion varchar(50) default '',
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A' /* A=activo , X = Desactivado*/
);

CREATE TABLE tb_factura_compras (    
    _ruc varchar(15),   
    id_factura varchar(20) primary key,
    _id_empleado varchar(15),
    fecha_compra date, /* FECHA EN EN LA QUE SE COMPRO----*/
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A', /* A=activo , X = Desactivado*/    
    constraint FOREIGN KEY(_ruc) REFERENCES tb_proveedores(ruc),
    constraint FOREIGN KEY(_id_empleado) REFERENCES tb_empleados(id_empleado)
);

create table tb_detalle_compras(
    id_compras int not null,
    _id_factura varchar(20),
    _id_producto int(11), 
    cantidad float,   
    valor_compra float,
    valor_real_compra float,
    stok float,
    descuento float,
    valor_venta float,
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A',
    constraint FOREIGN KEY(_id_producto) REFERENCES tb_productos (id_producto),
    constraint FOREIGN KEY(_id_factura) REFERENCES tb_factura_compras (id_factura),
    constraint primary key(id_compras,_id_factura,_id_producto)
);

/*-----------VENTAS ------------*/
CREATE TABLE tb_clientes (    
    id_cliente int(11) NOT NULL AUTO_INCREMENT primary key,
    nombres varchar(100),    
    cedula varchar(30),    
    correo varchar(30) default '',    
    telefono varchar(10) default '',
    direccion varchar(50) default '',
    registrado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A' /* A=activo , X = Desactivado*/
);

CREATE TABLE tb_factura_ventas (    
    id_factura int(11) NOT NULL AUTO_INCREMENT primary key,/*cedula*/
    _id_cliente int(11),
    _id_empleado varchar(15),
    fecha_venta timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,    
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A', /* A=activo , X = Desactivado*/
    constraint FOREIGN KEY(_id_cliente) REFERENCES tb_clientes(id_cliente),
    constraint FOREIGN KEY(_id_empleado) REFERENCES tb_empleados(id_empleado)
);

CREATE TABLE tb_detalle_ventas (  
    id_ventas int,     
    _id_factura int(11),
    _id_producto int(11),    
    cantidad float,
    precio_venta float,
    descuento float,
    fecha_transaccion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,    
    modificado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado char(1) default 'A', /* A=activo , X = Desactivado*/
    constraint primary key( id_ventas,_id_factura,_id_producto),
    constraint FOREIGN KEY(_id_factura) REFERENCES tb_factura_ventas(id_factura),
    constraint FOREIGN KEY(_id_producto) REFERENCES tb_productos(id_producto)    
);
/*-------------------------------------------------------*/

