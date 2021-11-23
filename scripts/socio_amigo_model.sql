CREATE DATABASE socio_amigo;

USE socio_amigo;

CREATE TABLE roles (
	idrole int NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	active boolean DEFAULT 1,
	CONSTRAINT pk_role PRIMARY KEY (idrole)
);

CREATE TABLE users (
	iduser int NOT NULL AUTO_INCREMENT,
	idrole int NOT NULL,
	name varchar(150) NOT NULL,
	email varchar(150) NOT NULL,
	mobil varchar(15),
	active boolean DEFAULT 1,
	CONSTRAINT pk_user PRIMARY KEY (iduser),
	CONSTRAINT fk_user_role FOREIGN KEY (idrole) REFERENCES roles (idrole)
);

CREATE TABLE userspass (
	iduserpass int NOT NULL AUTO_INCREMENT,
	iduser int NOT NULL,
	pass varchar(100) NOT NULL,
	created datetime DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_userpass PRIMARY KEY (iduserpass),
	CONSTRAINT fk_user_userpass FOREIGN KEY (iduser) REFERENCES users(iduser)
);

CREATE TABLE menus (
	idmenu int NOT NULL AUTO_INCREMENT,
	idmenudad int,
	name varchar(50) NOT NULL,
	icon varchar(50),
	`order` int NOT NULL,
	submenu boolean DEFAULT 0,
	active boolean DEFAULT 1,
	CONSTRAINT pk_menu PRIMARY KEY (idmenu)
);

CREATE TABLE rolesmenus (
	idrolemenu int NOT NULL AUTO_INCREMENT,
	idrole int NOT NULL,
	idmenu int NOT NULL,
	CONSTRAINT pk_rolemenu PRIMARY KEY (idrolemenu),
	CONSTRAINT fk_rolemenu_role FOREIGN KEY (idrole) REFERENCES roles (idrole),
	CONSTRAINT fk_rolemenu_menu FOREIGN KEY (idmenu) REFERENCES menus (idmenu)
);

CREATE TABLE partners (
	idpartner int NOT NULL AUTO_INCREMENT,
	dni varchar(15) NOT NULL,
	name varchar(150) NOT NULL,
	email varchar(150),
	mobil varchar(15) NOT NULL,
	address varchar(250),
	active boolean DEFAULT 1,
	CONSTRAINT pk_partner PRIMARY KEY (idpartner)
);

CREATE TABLE partnerspass (
	idpartnerpass int NOT NULL AUTO_INCREMENT,
	idpartner int NOT NULL,
	pass varchar(100) NOT NULL,
	created datetime DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_partnerpass PRIMARY KEY (idpartnerpass),
	CONSTRAINT fk_partnerpass_partner FOREIGN KEY (idpartner) REFERENCES partners (idpartner)
);

CREATE TABLE associations (
	idassociation int NOT NULL AUTO_INCREMENT,
	idmanager int NOT NULL,
	name varchar(150) NOT NULL,
	CONSTRAINT pk_association PRIMARY KEY (idassociation)
);

CREATE TABLE shops (
	idshop int NOT NULL AUTO_INCREMENT,
	idpartner int NOT NULL,
	idassociation int NOT NULL,
	location varchar(100) NOT NULL,
	`number` varchar(10) NOT NULL,
	name varchar(150) NOT NULL,
	active boolean DEFAULT 1,
	CONSTRAINT pk_shop PRIMARY KEY (idshop, idpartner),
	CONSTRAINT fk_shop_partner FOREIGN KEY (idpartner) REFERENCES partners (idpartner),
	CONSTRAINT fk_shop_association FOREIGN KEY (idassociation) REFERENCES associations (idassociation)
);


CREATE TABLE fees (
	idfee int NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	description varchar(150),
	period varchar(4) NOT NULL,
	created datetime DEFAULT CURRENT_TIMESTAMP,
	expiresin datetime NOT NULL,
	`value` double(8,2) DEFAULT 0,
	penalty double(8,2) DEFAULT 0,
	`state` varchar(15) DEFAULT 'Creada',
	CONSTRAINT pk_collection PRIMARY KEY (idfee)
);

CREATE TABLE feesshops (
	idfeeshop int NOT NULL AUTO_INCREMENT,
	idfee int NOT NULL,
	idshop int NOT NULL,
	idpartner int NOT NULL,
	paiddate datetime,
	paidtype varchar(50),
	paidperiod varchar(4),
	paidvoucher varchar(25),
	paidvalue double(8,2) DEFAULT 0,
	paidimage varchar(250),
	`state` varchar(15) DEFAULT 'Pendiente',
	CONSTRAINT pk_feeshop PRIMARY KEY (idfeeshop),
	CONSTRAINT fk_feeshop_fee FOREIGN KEY (idfee) REFERENCES fees (idfee),
	CONSTRAINT fk_feeshop_shop FOREIGN KEY (idshop) REFERENCES shops (idshop),
	CONSTRAINT fk_feeshop_partner FOREIGN KEY (idpartner) REFERENCES shops (idpartner)
);

CREATE TABLE documents (
	iddocument int NOT NULL AUTO_INCREMENT,
	`type` varchar(25) NOT NULL,
	documenttype varchar(25) NOT NULL,
	documentnumber varchar(50) NOT NULL,
	name varchar(150) NOT NULL,
	dni varchar(15) NOT NULL,
	address varchar(250) NOT NULL,
	mobil varchar(15) NOT NULL,
	description varchar(250) NOT NULL,
	rate double(8,2) DEFAULT 0,
	rateiva double(8,2) DEFAULT 0,
	discount double(8,2) DEFAULT 0,
	iva double(8,2) DEFAULT 0,
	created datetime DEFAULT CURRENT_TIMESTAMP,
	`state` varchar(15) DEFAULT 'Nuevo',
	`image` varchar(250),
	CONSTRAINT pk_document PRIMARY KEY (iddocument)
);

CREATE TABLE meetings (
	idmeeting int NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	description varchar(150),
	period varchar(4) NOT NULL,
	datemeeting datetime NOT NULL,
	penalty double(8,2) DEFAULT 0,
	status varchar(15) DEFAULT 'Creada',
	CONSTRAINT pk_meeting PRIMARY KEY (idmeeting)
);

