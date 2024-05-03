CREATE TABLE Staff(  
st_ID int NOT NULL,  
st_name varchar(30) NOT NULL,  
st_phNo char(9),  
st_title varchar(30) NOT NULL,  
    CONSTRAINT st_ID_pk PRIMARY KEY (st_ID)  
);
INSERT INTO Staff VALUES (1,'Berra Yıldız', '123546432', 'nurse');
INSERT INTO Staff VALUES (2,'Servet Aksu', '425456533', 'nurse');
INSERT INTO Staff VALUES (3,'Bilge Soylu', '248745309', 'nurse');
INSERT INTO Staff VALUES (4,'Azade Korutürk', '712563023', 'nurse');
INSERT INTO Staff VALUES (5,'Alattin Sezgin', '833616179', 'nurse');
INSERT INTO Staff VALUES (6,'Tahir Akça', '653190247', 'nurse');
INSERT INTO Staff VALUES (10,'Evrim Sezen', '744878599', 'lab tech');
INSERT INTO Staff VALUES (11,'Dilara Akar Fırat', '481235131', 'lab tech');
INSERT INTO Staff VALUES (12,'Kader Akgündüz', '641509388', 'lab tech');
INSERT INTO Staff VALUES (100,'Tunahan Çetin', '536343083', 'manager');
INSERT INTO Staff VALUES (101,'Elvan Yıldırım Gül', '272810462', 'manager');
INSERT INTO Staff VALUES (102,'Yiğit Güçlü', '536266610', 'manager');
select* from Staff;


 CREATE TABLE City(  
city_ID int NOT NULL,  
city_name varchar(30) NOT NULL,  
	CONSTRAINT city_ID_pk PRIMARY KEY (city_ID)  
);
INSERT INTO City VALUES (34,'İstanbul');
INSERT INTO City VALUES (35,'İzmir');
INSERT INTO City VALUES (06,'Ankara');

select* from City;

CREATE TABLE Center(  
    center_ID int NOT NULL,  
    center_name varchar(30) NOT NULL,  
    city int NOT NULL,
    password varchar(50) NOT NULL, 
    CONSTRAINT center_ID_pk PRIMARY KEY (center_ID),  
    FOREIGN KEY (city) REFERENCES City (city_ID) 
);


INSERT INTO Center (center_ID, center_name, city, password) VALUES ('340', 'İstanbul Kan Deposu', '34', '340340');
INSERT INTO Center (center_ID, center_name, city, password) VALUES ('350', 'İzmir Kan Deposu', '35', '350350');
INSERT INTO Center (center_ID, center_name, city, password) VALUES ('600', 'Ankara Kan Deposu', '06', '600600');

select * from Center;

  CREATE TABLE Donor(    
d_ID int NOT NULL,    
d_name varchar(30) NOT NULL,    
d_age varchar(10),    
d_sex varchar(10),    
d_blGroup varchar(10),    
d_date date,    
d_stId int NOT NULL,    
d_city int NOT NULL,    
     CONSTRAINT d_ID_pk PRIMARY KEY (d_ID),  
     FOREIGN KEY (d_city) REFERENCES CITY (city_ID),  
     FOREIGN KEY (d_stId) REFERENCES STAFF (st_ID)  
    );
INSERT INTO Donor VALUES (123,'Haluk Yaman','30','M','A+','5-Apr-2022',1, 34);
INSERT INTO Donor VALUES (125,'Sevginur Bilir','25','F','B-','12-May-2022',3, 35);
INSERT INTO Donor VALUES (657,'Seyfullah Yıldırım','37','M','0+','17-Jun-2022',5, 06);
INSERT INTO Donor VALUES (234,'Vedat Ertaş','41','M','AB+','28-Apr-2022',6, 06);
INSERT INTO Donor VALUES (987,'Berk Ergül','24','M','B+','15-Mar-2022',2, 34);
INSERT INTO Donor VALUES (564,'Baturay Alemdar','28','M','B-','19-May-2022',4, 35);
INSERT INTO Donor VALUES (236,'Yadigar Akar','26','F','0-','7-Jun-2022',2, 34);
INSERT INTO Donor VALUES (856,'Çağla Aksu','22','F','AB-','30-Jan-2022',1, 34);

select * from Donor;

CREATE TABLE Recipient(   
rec_ID int NOT NULL,   
rec_name varchar(30) NOT NULL,   
rec_age varchar(10),   
rec_blGroup varchar(10),   
rec_sex varchar(10),   
rec_date date,     
rec_stId int NOT NULL,   
rec_city int NOT NULL,  
center int NOT NULL,   
	CONSTRAINT rec_ID_pk PRIMARY KEY (rec_ID),   
    FOREIGN KEY (rec_stId) REFERENCES Staff (st_ID), 
    FOREIGN KEY (rec_city) REFERENCES City (city_ID),
    FOREIGN KEY (center) REFERENCES Center (center_ID)
    );

INSERT INTO Recipient VALUES (2687,'Ünal Saydam','31','A-','M','5-Apr-2022',1, 34,'340');
INSERT INTO Recipient VALUES (8398,'Esra Yönet','29','AB+','F','5-Apr-2022',5, 06,'600');
INSERT INTO Recipient VALUES (2047,'Emrullah Bilgiç','56','0','M','5-Apr-2022',3, 35,'350');
INSERT INTO Recipient VALUES (9810,'Sema Duyu','23','B-','F','5-Apr-2022',2, 34,'340');
INSERT INTO Recipient VALUES (9762,'Vildan Sevgi','45','A+','F','5-Apr-2022',6, 06,'600');
INSERT INTO Recipient VALUES (8481,'Hikmet İnanç','37','AB-','M','5-Apr-2022',3, 35,'350');
INSERT INTO Recipient VALUES (3246,'Adem Cevizci','49','A+','M','5-Apr-2022',1, 06,'600');
INSERT INTO Recipient VALUES (4995,'Seyran Küçüközkan','52','AB+','F','5-Apr-2022',2, 34,'340');
INSERT INTO Recipient VALUES (7228,'Melda Duman','25','B+','F','5-Apr-2022',1, 34,'340');
INSERT INTO Recipient VALUES (7111,'Burak Sözer','30','A+','M','5-Apr-2022',6, 06,'600');
INSERT INTO Recipient VALUES (3980,'Seyhan Kuruoğlu','39','B+','F','5-Apr-2022',4, 35,'350');

select * from Recipient;


CREATE TABLE Stock (
  center_ID int NOT NULL,
  center_name varchar(30) NOT NULL,
  stock_ID int NOT NULL,
  stockBl_group varchar(10),
  stockBl_qnty float,
   CONSTRAINT stock_ID_pk PRIMARY KEY (stock_ID), 
  FOREIGN KEY (center_ID) REFERENCES Center (center_ID)


 

);
INSERT INTO Stock VALUES ('340','İstanbul Kan Merkezi','10000','A+', 2);
INSERT INTO Stock VALUES ('340','İstanbul Kan Merkezi','10001','AB+', 3);
INSERT INTO Stock VALUES ('340','İstanbul Kan Merkezi','10002','B+', 2);
INSERT INTO Stock VALUES ('340','İstanbul Kan Merkezi','10003','0+', 1);

INSERT INTO Stock VALUES ('600','Ankara Kan Merkezi','10004','A-', 4);
INSERT INTO Stock VALUES ('600','Ankara Kan Merkezi','10005','B-', 3);
INSERT INTO Stock VALUES ('600','Ankara Kan Merkezi','10006','AB-', 5);
INSERT INTO Stock VALUES ('600','Ankara Kan Merkezi','10007','0-', 3);

INSERT INTO Stock VALUES ('350','İzmir Kan Merkezi','10008','A-', 3);
INSERT INTO Stock VALUES ('350','İzmir Kan Merkezi','10009','AB+', 2);
INSERT INTO Stock VALUES ('350','İzmir Kan Merkezi','10010','B+', 1);
INSERT INTO Stock VALUES ('350','İzmir Kan Merkezi','10011','0-', 2);
INSERT INTO Stock VALUES ('350','İzmir Kan Merkezi','10012','0+', 3);


select *from Stock;



CREATE TABLE Analyze (
  anyz_ID int NOT NULL,
  anyz_group varchar(10),
  anyz_DisName varchar(30),
  anyz_stats int,
  st_ID int NOT NULL
);