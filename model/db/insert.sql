/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  SYSCOM
 * Created: 11-jun-2016
 */

 use db_syscomandes;

insert into tb_empleados(id_empleado,nombres) values('admin','Administrador');
insert into tb_empleados(id_empleado,nombres) values('user1','Usuario');

insert into tb_usuarios(id_usuario,passw) values('admin','827ccb0eea8a706c4c34a16891f84e7b');
insert into tb_usuarios(id_usuario,passw) values('user1','827ccb0eea8a706c4c34a16891f84e7b');

INSERT INTO tb_grupos (grupo) VALUES ('ADMIN - Acceso');
INSERT INTO tb_grupos (grupo) VALUES ('ADMIN - Seguridad');
INSERT INTO tb_grupos (grupo) VALUES ('ADMIN - Operaciones');
INSERT INTO tb_grupos (grupo) VALUES ('Operaciones');
INSERT INTO tb_grupos (grupo) VALUES ('ADMIN - Procesos');

/*------------------MENU PARA ADMINISTRADOR DE ACCESO 1-3 -------------------------*/
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (1, 'Admin. Grupos', 'index.php?pag=1');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (1, 'Admin. Opciones', 'index.php?pag=2');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (1, 'Admin. Accesos(Menu)','index.php?pag=3');

/*------------------MENU PARA ADMINISTRADOR DE SEGURIDAD 4-7 ---------------------*/
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (2, 'Admin. Roles', 'index.php?pag=4');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (2, 'Admin. Usuarios', 'index.php?pag=5');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (2, 'Admin. Usuarios - Roles', 'index.php?pag=6');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (2, 'Cambiar Clave (falta)', 'index.php?pag=7');

/*------------------MENU PARA ADMINISTRADOR GENERAL 8-13 ---------------------*/
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Categorias', 'index.php?pag=8');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Marcas', 'index.php?pag=9');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Admin. Productos', 'index.php?pag=10');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Admin. Clientes', 'index.php?pag=11');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Admin. Proveedores', 'index.php?pag=12');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (3, 'Admin. Pedidos', 'index.php?pag=13');

/*------------------  MENU PARA ADMINISTRADOR DEL SISTEMA 14-17 ---------------------*/
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (4, 'Adm. Ventas', 'index.php?pag=14');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (4, 'Fact. Compras', 'index.php?pag=15');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (4, 'Equipos en Prestamos', 'index.php?pag=16');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (4, 'Act. Stok', 'index.php?pag=17');
/*------------------  MENU PARA ADMINISTRADOR Y USUARIO 18-19 ---------------------*/
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (5, 'Realizar Pedido', 'index.php?pag=18');
INSERT INTO tb_menu (_id_grupo, opcion, contenido) VALUES (5, 'Consultar Precios', 'index.php?pag=19');

/*--------ROLES PARA LA APLICACION----------*/
INSERT INTO tb_roles (rol, estado) VALUES ('Super Usuario','A');
INSERT INTO tb_roles (rol, estado) VALUES ('Administrador', 'A');
INSERT INTO tb_roles (rol, estado) VALUES ('Admin Sistemas', 'A');
INSERT INTO tb_roles (rol, estado) VALUES ('Usuario', 'A');


INSERT INTO tb_usuarios_roles(_id_rol,_id_usuario,estado) values(1,'admin','A');
INSERT INTO tb_usuarios_roles(_id_rol,_id_usuario,estado) values(3,'user1','A');

/*super usuario*/
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (1, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (2, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (3, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (4, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (5, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (6, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (7, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (8, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (9, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (10, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (11, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (12, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (13, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (14, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (15, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (16, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (17, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (18, 1, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (19, 1, 'A');
/*Administrador*/
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (4, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (5, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (6, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (7, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (8, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (9, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (10, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (11, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (12, 2, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (13, 2, 'A');

/*ADMIN DEL SISTEMAS*/
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (8, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (9, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (10, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (11, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (12, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (13, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (14, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (15, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (16, 3, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (17, 3, 'A');

/*USUARIOS*/
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (18, 4, 'A');
INSERT INTO tb_accesos (_id_menu, _id_rol,  estado) VALUES (19, 4, 'A');

/*USUARIOS y ADMINSITRADOR*/


insert into tb_marcas(nombre,descripcion) VALUES('Norma','Productos Norma');
insert into tb_marcas(nombre,descripcion) VALUES('Escribe','Productos Escribe');
insert into tb_marcas(nombre,descripcion) VALUES('Apolo','Productos Apolo');
insert into tb_marcas(nombre,descripcion) VALUES('Bic','Productos Bic');
insert into tb_marcas(nombre,descripcion) VALUES('Nataraj','');
insert into tb_marcas(nombre,descripcion) VALUES('Carioca','');
insert into tb_marcas(nombre,descripcion) VALUES('STAEDTLER','');
insert into tb_marcas(nombre,descripcion) VALUES('LANCER','');
insert into tb_marcas(nombre,descripcion) VALUES('PELIKAN','');
insert into tb_marcas(nombre,descripcion) VALUES('BESTER','');
insert into tb_marcas(nombre,descripcion) VALUES('TUKAN','');
insert into tb_marcas(nombre,descripcion) VALUES('PAPER MATER','');
insert into tb_marcas(nombre,descripcion) VALUES('ARTESCO','');
insert into tb_marcas(nombre,descripcion) VALUES('FEBER CASTTEL','');
insert into tb_marcas(nombre,descripcion) VALUES('FANTAPE','');
insert into tb_marcas(nombre,descripcion) VALUES('ESTILO','');
insert into tb_marcas(nombre,descripcion) VALUES('KINGSTON','');
insert into tb_marcas(nombre,descripcion) VALUES('EAGLE','');
insert into tb_marcas(nombre,descripcion) VALUES('GRAPAS','');


insert into tb_categorias(nombres,descripcion) VALUES('CUADERNO','');
insert into tb_categorias(nombres,descripcion) VALUES('ESFERO','');
insert into tb_categorias(nombres,descripcion) VALUES('LAPIZ','');
insert into tb_categorias(nombres,descripcion) VALUES('BORRADOR','');
insert into tb_categorias(nombres,descripcion) VALUES('MARCADOR','');
insert into tb_categorias(nombres,descripcion) VALUES('PORTAMINA','');
insert into tb_categorias(nombres,descripcion) VALUES('RESALTADOR','');
insert into tb_categorias(nombres,descripcion) VALUES('CORRECTOR','');
insert into tb_categorias(nombres,descripcion) VALUES('CARPETA','');
insert into tb_categorias(nombres,descripcion) VALUES('FORRO','');
insert into tb_categorias(nombres,descripcion) VALUES('ESPUMA FLEX','');
insert into tb_categorias(nombres,descripcion) VALUES('FOAMI','');
insert into tb_categorias(nombres,descripcion) VALUES('FORMATOS','');
insert into tb_categorias(nombres,descripcion) VALUES('GOMA','');
insert into tb_categorias(nombres,descripcion) VALUES('REGLA','');
insert into tb_categorias(nombres,descripcion) VALUES('GRADUADOR','');
insert into tb_categorias(nombres,descripcion) VALUES('LIBRETA','');
insert into tb_categorias(nombres,descripcion) VALUES('LUPA','');
insert into tb_categorias(nombres,descripcion) VALUES('MASKING','');
insert into tb_categorias(nombres,descripcion) VALUES('MINAS','');
insert into tb_categorias(nombres,descripcion) VALUES('NORMOGRAFO','');
insert into tb_categorias(nombres,descripcion) VALUES('PAPEL','');
insert into tb_categorias(nombres,descripcion) VALUES('SACAPUNTA','');
insert into tb_categorias(nombres,descripcion) VALUES('SILICONA','');
insert into tb_categorias(nombres,descripcion) VALUES('SOBRE','');
insert into tb_categorias(nombres,descripcion) VALUES('TAYPE','');
insert into tb_categorias(nombres,descripcion) VALUES('TEMPERA','');
insert into tb_categorias(nombres,descripcion) VALUES('Compaz','');
insert into tb_categorias(nombres,descripcion) VALUES('PEGA BARRA','');
insert into tb_categorias(nombres,descripcion) VALUES('CD','');
insert into tb_categorias(nombres,descripcion) VALUES('CARTULINA','');
insert into tb_categorias(nombres,descripcion) VALUES('TACHUELA','');
insert into tb_categorias(nombres,descripcion) VALUES('GRAPAS','');
insert into tb_categorias(nombres,descripcion) VALUES('CORCHO','');
insert into tb_categorias(nombres,descripcion) VALUES('FLASH','');
insert into tb_categorias(nombres,descripcion) VALUES('COLOR','');
insert into tb_categorias(nombres,descripcion) VALUES('ARCHIVADOR','');
insert into tb_categorias(nombres,descripcion) VALUES('TIJERA','');
insert into tb_categorias(nombres,descripcion) VALUES('PLASTILINA','');

 insert into tb_proveedores(ruc,nombres,correo,telefono) values('0696502001001','La casa','info@mail.com','032511555');