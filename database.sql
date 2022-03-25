create database course_db;
use course_db;


create table course (
id INT(11)  primary key auto_increment,
course varchar (1000),
students varchar (1000),
arquivo BLOB,
data_lancamento TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE courseOld SELECT * FROM course;
INSERT INTO courseOld SELECT * FROM course;