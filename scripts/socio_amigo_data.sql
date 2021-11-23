/*==============================================================*/
/* Table: roles                                                 */
/*==============================================================*/
INSERT INTO roles (idrole, name, active) VALUE (1, 'Administrador', true);

/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
INSERT INTO users (iduser, idrole, name, email, mobil, active) VALUE (null, 1, 'David Valdivieso', 'eddavidva@gmail.com', '0984029355', true);

/*==============================================================*/
/* Table: userspass                                             */
/*==============================================================*/
INSERT INTO userspass (iduserpass, iduser, pass, created) VALUES (null, 1, 'eddavidva@gmail.com', CURRENT_TIMESTAMP);

/*==============================================================*/
/* Table: menus                                                 */
/*==============================================================*/
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (1,  null, 'Mis Cuotas', 'fas fa-comment-dollar', 1, false, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (11, 1, 'Pagadas', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (12, 1, 'Pendientes', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (13, 1, 'Balance actual', '', 3, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (14, 1, 'Filtrar balance', '', 4, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (2,  null, 'Cuotas', 'fas fa-comment-dollar', 2, false, true);
INSERT INTO menus(idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (21, 2, 'Nueva cuota', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (22, 2, 'Ver cuotas creadas', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (23, 2, 'Filtrar cuotas', '', 3, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (3, null, 'Ingresos', 'fas fa-hand-holding-usd', 3, false, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (31, 3, 'Registrar ingreso', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (32, 3, 'Filtrar ingresos', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (4, null, 'Gastos', 'fas fa-hand-holding-usd', 4, false, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (41, 4, 'Registrar gasto', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (42, 4, 'Filtrar gastos', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (5, null, 'Historial', 'fas fa-hand-holding-usd', 5, false, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (51, 5, 'Filtrar cuotas', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (52, 5, 'Filtrar ingresos', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (53, 5, 'Filtrar gastos', '', 3, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (6, null, 'Administración', 'fas fa-cogs', 6, false, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (61, 6, 'Usuarios', '', 1, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (62, 6, 'Periodos', '', 2, true, true);
INSERT INTO menus (idmenu, idmenudad, name, icon, `order`, submenu, active) VALUES (63, 6, 'Roles', '', 3, true, true);

/*==============================================================*/
/* Table: rolesmenus                                            */
/*==============================================================*/
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 1);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 11);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 12);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 13);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 14);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 2);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 21);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 22);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 23);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 3);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 31);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 32);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 4);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 41);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 42);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 5);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 51);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 52);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 53);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 6);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 61);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 62);
INSERT INTO rolesmenus (idrolemenu, idrole, idmenu) VALUES (null, 1, 63);