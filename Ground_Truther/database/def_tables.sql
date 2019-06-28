/* this document contains definitions for all tables in database ground_truther */

--define tbl_personal_basic
drop table if exists tbl_personal_basic;
create table tbl_personal_basic
(id_part int auto_increment not null primary key,
email varchar(63) default null,
password varchar(64),
unique index uni_id(email))
engine=InnoDB;

--define tbl_personal_adv
drop table if exists tbl_personal_adv;
create table tbl_personal_adv
(id_part_a int, 
id_adv int auto_increment not null primary key,
name varchar(63) default null,
surname varchar(63) default null,
country varchar(63) default null,
town varchar(63) default null,
phone varchar(63) default null,
constraint idpart foreign key (id_part_a)
	REFERENCES tbl_personal_basic(id_part)
	ON DELETE CASCADE)
engine=InnoDB;

--define tbl_landscape
drop table if exists tbl_landscape;
create table tbl_landscape
(id_land int auto_increment not null primary key,
name_landscape varchar(63) default null)
engine=InnoDB;

--define tbl_disturbance
drop table if exists tbl_disturbance;
create table tbl_disturbance
(id_disturbance int auto_increment not null primary key,
name_disturbance varchar(63) default null)
engine=InnoDB;

--define tbl_obs
drop table if exists tbl_obs;
create table tbl_obs
(id_part int,
id_obs int auto_increment not null primary key,
coords varchar(63),
id_disturbance int,
id_land int,
comment mediumtext,
date_obs date,
img_name varchar(63),
constraint idev foreign key (id_disturbance)
	REFERENCES tbl_disturbance(id_disturbance)
	ON DELETE CASCADE,
constraint idland foreign key (id_land)
	REFERENCES tbl_landscape(id_land)
	ON DELETE CASCADE) 
engine=InnoDB;



