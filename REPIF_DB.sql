drop database REPIF_db;

create database REPIF_db;

CREATE TABLE Script(
   ScriptName VARCHAR(50) NOT NULL,
   Path VARCHAR(50) NOT NULL,
   Description VARCHAR(50) NOT NULL,
   PRIMARY KEY(ScriptName)
);

CREATE TABLE SmartBox(
   HostName VARCHAR(16) NOT NULL,
   Description VARCHAR(50) NOT NULL,
   Location VARCHAR(50) NOT NULL,
   PRIMARY KEY(HostName)
);

CREATE TABLE Users(
   UserNo INT unique not null AUTO_INCREMENT,
   Name VARCHAR(50) NOT NULL,
   FirstName VARCHAR(50) NOT NULL,
   Technician VARCHAR(1) NOT NULL,
   Email VARCHAR(50) NOT NULL ,
   Passwd VARCHAR(50) NOT NULL,
   HostName VARCHAR(16) NOT NULL,
   PRIMARY KEY(UserNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);


CREATE TABLE Groups(
   GroupNo SMALLINT unique not null AUTO_INCREMENT,
   GroupName VARCHAR(20) NOT NULL,
   Description VARCHAR(50) NOT NULL,
   HostName VARCHAR(16) NOT NULL,
   PRIMARY KEY(GroupNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE Pin(
   HostName VARCHAR(16) NOT NULL,
   PinNo SMALLINT unique not null AUTO_INCREMENT,
   Input SMALLINT NOT NULL,
   Designation VARCHAR(50) NOT NULL,
   PRIMARY KEY(HostName, PinNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE Events(
   HostName VARCHAR(16) NOT NULL,
   PinNo SMALLINT unique not null AUTO_INCREMENT,
   EventCode VARCHAR(1) NOT NULL,
   Description VARCHAR(50) NOT NULL,
   PRIMARY KEY(HostName, PinNo, EventCode),
   FOREIGN KEY(HostName, PinNo) REFERENCES Pin(HostName, PinNo)
);

CREATE TABLE Switch_Execute(
   HostName VARCHAR(16) NOT NULL,
   PinNo SMALLINT unique not null AUTO_INCREMENT,
   EventCode VARCHAR(1) NOT NULL,
   GroupNo SMALLINT NOT NULL,
   TargetFunctionCode VARCHAR(1) NOT NULL,
   Description VARCHAR(50) NOT NULL,
   SequenceNo INT NOT NULL,
   WaitingDuration INT NOT NULL,
   PRIMARY KEY(HostName, PinNo, EventCode, GroupNo),
   UNIQUE(TargetFunctionCode),
   FOREIGN KEY(HostName, PinNo, EventCode) REFERENCES Events(HostName, PinNo, EventCode),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo)
);

CREATE TABLE `Use`(
   GroupNo SMALLINT unique not null AUTO_INCREMENT,
   ScriptName VARCHAR(50) NOT NULL,
   PRIMARY KEY(GroupNo, ScriptName),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(ScriptName) REFERENCES Script(ScriptName)
);




CREATE TABLE Concern(
   GroupNo SMALLINT unique not null AUTO_INCREMENT,
   HostName VARCHAR(16) NOT NULL,
   PinNo SMALLINT NOT NULL,
   PRIMARY KEY(GroupNo, HostName, PinNo),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(HostName, PinNo) REFERENCES Pin(HostName, PinNo)
);

CREATE TABLE Manage(
   HostName VARCHAR(16) NOT NULL,
   UserNo INT NOT NULL,
   PRIMARY KEY(HostName, UserNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName),
   FOREIGN KEY(UserNo) REFERENCES Users(UserNo)
);
