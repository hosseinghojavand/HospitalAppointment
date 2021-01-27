
CREATE TABLE Speciality (
    ID integer IDENTITY(1,1) ,  -- auto increment primary key
    name NVARCHAR(64) NOT NULL,

    PRIMARY KEY (ID) ,
) ;

INSERT  into Speciality (name) values ("عمومی");
INSERT  into Speciality (name) values ("داخلی");
INSERT  into Speciality (name) values ("جراحی مغز و اعصاب");
INSERT  into Speciality (name) values ("زنان");
INSERT  into Speciality (name) values ("کلیه و مجاری ادراری");
INSERT  into Speciality (name) values ("چشم پزشکی");
INSERT  into Speciality (name) values ("دندانپزشکی");
INSERT  into Speciality (name) values ("ارتوپد");
INSERT  into Speciality (name) values ("روانشناس");
INSERT  into Speciality (name) values ("اپتومتری");
INSERT  into Speciality (name) values ("فیزیوتراپی");
INSERT  into Speciality (name) values ("پوست");

CREATE TABLE Hospital(
    ID INTEGER identity (1,1),
    name NVARCHAR(64) NOT NULL ,
    city NVARCHAR(64) NOT NULL ,
    address NVARCHAR(64) NOT NULL ,
    phone NVARCHAR(64) NOT NULL ,
    PRIMARY KEY(ID),
);

INSERT into Hospital (name , city , address , phone) values ("بیمارستان غرضی" , "اصفهان" , "خیابان کاوه خ غرضی" , "34515151" );
INSERT into Hospital (name , city , address , phone) values ("بیمارستان الزهرا" , "اصفهان" , "دروازه شیراز" , "34515152" );
INSERT into Hospital (name , city , address , phone) values ("بیمارستان خورشید" , "اصفهان" , "خیابان خورشید" , "34515153" );

CREATE TABLE Insurance(
    ID INTEGER ,
    name NVARCHAR(64) NOT NULL ,
    PRIMARY KEY (ID),
);

INSERT INTO Insurance (ID , name) VALUES (1 , "تامین اجتماعی");
INSERT INTO Insurance (ID , name) VALUES (2 , "نیرو های مسلح");
INSERT INTO Insurance (ID , name) VALUES (3 , "خدمات درمانی");
INSERT INTO Insurance (ID , name) VALUES (4 , "بیمه تکمیلی");


CREATE TABLE Doctor (
    ID INTEGER ,
    first_name NVARCHAR(64) NOT NULL ,
    last_name NVARCHAR(64) NOT NULL ,
    speciality_id INTEGER ,
    extra_info  NVARCHAR(256),
    score INTEGER DEFAULT 0,
    avatar_address NVARCHAR(256) ,
    gender INTEGER , -- 1 man  2 woman
    hospital_id INTEGER ,
    age INTEGER DEFAULT 0 ,
    PRIMARY KEY (ID) ,
    FOREIGN KEY (speciality_id) REFERENCES Speciality(ID) ON DELETE SET NULL ,
    FOREIGN KEY (hospital_id) REFERENCES Hospital(ID) ON DELETE SET NULL ,
) ;


CREATE TABLE Time (
  ID integer identity (1,1),
  speciality_id INTEGER ,
  week_day INTEGER ,
  start_hour INTEGER ,
  start_min INTEGER ,
  end_hour INTEGER ,
  end_min integer ,
  total_capacity INTEGER ,
  primary key (ID) ,
  FOREIGN KEY (speciality_id) REFERENCES Speciality(ID) ON DELETE SET NULL ,
) ;

CREATE TABLE Patient (
    national_code INTEGER ,
    first_name NVARCHAR(64) NOT NULL ,
    last_name NVARCHAR(64) NOT NULL ,
    avatar_address NVARCHAR(256) ,
    age INTEGER DEFAULT 0 ,
    gender INTEGER , -- 1 man  2 woman
    insurance_id INTEGER,
    PRIMARY KEY (national_code) ,
    FOREIGN KEY (insurance_id) REFERENCES Insurance(ID) ON DELETE SET NULL ,
) ;

CREATE TABLE Attendance (
  ID INTEGER identity (1,1),
  time_id INTEGER,
  speciality_id INTEGER,
  patient_id INTEGER,

  PRIMARY KEY (ID),
  FOREIGN KEY (time_id) REFERENCES Speciality(ID) ON DELETE SET NULL ,
  FOREIGN KEY (patient_id) REFERENCES Patient(national_code) ON DELETE SET NULL ,
  FOREIGN KEY (time_id) REFERENCES Time(ID) ON DELETE SET NULL ,
);



CREATE TABLE Comment(
  ID INTEGER identity (1,1),
  patient_id  integer,
  date NVARCHAR(64),
  text NVARCHAR(256) ,
  doctor_id INTEGER,
  PRIMARY KEY (ID),
  FOREIGN KEY (patient_id) REFERENCES Patient(national_code) ON DELETE SET NULL ,
  FOREIGN KEY (doctor_id) REFERENCES Doctor(ID) ON DELETE SET NULL ,
);


CREATE TABLE Authentication(
  ID INTEGER identity (1,1),
  patient_id INTEGER default  -1,
  doctor_id integer default -1,
  password integer not null ,

  PRIMARY KEY (ID),

  FOREIGN KEY (patient_id) REFERENCES Patient(national_code) ON DELETE SET NULL ,
  FOREIGN KEY (doctor_id) REFERENCES Doctor(ID) ON DELETE SET NULL ,
);
