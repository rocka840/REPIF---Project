
create database REPIF_db;
use REPIF_db;

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


INSERT INTO SmartBox (HostName, Description, Location)
VALUES (“SB_1”,”ModelA”,”Building1-apartment3”);

INSERT INTO SmartBox (HostName, Description, Location)
VALUES (“SB_7”,”ModelA”,”Building7-apartment2”);

INSERT INTO SmartBox (HostName, Description, Location)
VALUES (“SB_23”,”ModelB”,”Building4-petshop”);

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES (“SB_1”,”7”,”X”, “GPIO4”);

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES (“SB_1”,”11”,”X”, “GPIO17”);

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES (“SB_7”,”33”, “0”, “GPIO13”);

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES (“SB_23”,”35”, “0”, “GPIO19”);

INSERT INTO Groups (GroupNo, GroupName, Description, HostName)
VALUES (1,”CHIEF”,”Lamps in the kitchen”, “SB_7”); 

INSERT INTO Groups (GroupNo, GroupName, Description, HostName)
VALUES (3,”ALL”,”All lamps”, “SB_23”); 

INSERT INTO Groups (GroupNo, GroupName, Description, HostName)
VALUES (11,”GARAGE”,”Garage door”, “SB_1”);

INSERT INTO Groups (GroupNo, GroupName, Description, HostName)
VALUES (13,”FLUR”,”Hallway lamps”, “SB_1”);

INSERT INTO Concern (GroupNo, HostName, PinNo)
VALUES (11,”SB_1”, 7); 

INSERT INTO Concern (GroupNo, HostName, PinNo)
VALUES (13,”SB_1”, 11); 

INSERT INTO Concern (GroupNo, HostName, PinNo)
VALUES (1,”SB_7”, 33); 

INSERT INTO Concern (GroupNo, HostName, PinNo)
VALUES (3,”SB_23”, 35); 

INSERT INTO Script (ScriptName, Path, Description)
VALUES (“Dimmer”,”/Switch/Dimmer.sh”, “Dim lamp”);

INSERT INTO Script (ScriptName, Path, Description)
VALUES (“Bell”,”/Sound/bell.sh”, “Play ringtone”);

INSERT INTO Script (ScriptName, Path, Description)
VALUES (“Strobo”,”/Switch/Strobo.sh”, “Make lamp flash quickly”);

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 1,”Dimmer”);

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 3,”Bell”);

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 11,”Strobo”);

INSERT INTO Events (HostName, PinNo, EventCode, Description)
VALUES ( “SB_1”,7, “K”, “Press light switch briefly”);

INSERT INTO Events (HostName, PinNo, EventCode, Description)
VALUES ( “SB_1”,11, “L”, “Long press touch field”); 

INSERT INTO Events (HostName, PinNo, EventCode, Description)
VALUES ( “SB_7”,33, “K”, “Touch field briefly”); 

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration)
VALUES ( “SB_1”,11, “L”, 11, “E”, “Switch on alarm”, 2, 5);

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration)
VALUES ( “SB_7”,33, “K”, 1, “U”, “Switch light in the bathroom”,0,0); 

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration)
VALUES ( “SB_1”,7, “K”, 13, “A”, “Close window”, 1,0); 

INSERT INTO Users (UserNo, Name, Firstname, Technician, Email, Passwd, HostName)
VALUES ( 3 , “Theis”, “Anna”, “X”, “a.theis@bt.lu”, “3!zhnT5”, “SB_1”);

INSERT INTO Users (UserNo, Name, Firstname, Technician, Email, Passwd, HostName)
VALUES ( 7 , “Schmit”, “Jean”, “jean@jmail.com”, “N”, “1234abcd”, “SB_3”);

INSERT INTO Users (UserNo, Name, Firstname, Technician, Email, Passwd, HostName)
VALUES ( 11, “Fellens”, “Claude”, “X”, “claude@fellens.lu”, “Cl4ud3”, “SB_7”);

INSERT INTO Users (UserNo, Name, Firstname, Technician, Email, Passwd, HostName)
VALUES ( 13, “Adam”, “Laure”, “N”, “laury@jmail.com”, “+lowä+!4”, “SB_9”);
