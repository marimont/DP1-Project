DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS machines;

CREATE TABLE users(
	ID int(11) NOT NULL AUTO_INCREMENT,
	Name varchar(50) NOT NULL,
	Surname varchar(50) NOT NULL,
	Email varchar(50) NOT NULL,
	Password varchar(34) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE machines(
	ID int(11) NOT NULL AUTO_INCREMENT,
	Name varchar(50) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE reservations(
	ID int(11) NOT NULL AUTO_INCREMENT,
	IDU int(11) NOT NULL,
	IDM int(11) NOT NULL,
	StartTime int(5) NOT NULL,
	EndTime int(5) NOT NULL,
	TimeStamp int(5) NOT NULL,
	PRIMARY KEY(ID),
	FOREIGN KEY(IDU) references users(ID),
	FOREIGN KEY(IDM) references machines(ID)
);

