CREATE DATABASE BUS_DB2;
USE BUS_DB2;

CREATE TABLE Customer (
    CustomerID INT(15) PRIMARY KEY AUTO_INCREMENT,
    CustomerFName VARCHAR(30) NOT NULL,
    CustomerLName VARCHAR(30) NOT NULL,
    CustomerEmail VARCHAR(30) NOT NULL,
    CustomerPhoneNum INT(15) NOT NULL,
    CustomerPassword VARCHAR(255) NOT NULL
);

CREATE TABLE BusOperator (
    OperatorID INT(15) PRIMARY KEY AUTO_INCREMENT,
    OperatorFName VARCHAR(30) NOT NULL,
    OperatorLName VARCHAR(30) NOT NULL,
    OperatorEmail VARCHAR(30) NOT NULL,
    OperatorPhoneNum INT(15) NOT NULL,
    OperatorPassword VARCHAR(255) NOT NULL
);

CREATE TABLE Bus (
    BusID INT AUTO_INCREMENT PRIMARY KEY,
    BusName VARCHAR(30) NOT NULL,
    NumberPlate VARCHAR(30) NOT NULL
);

CREATE TABLE Route (
    RouteID INT AUTO_INCREMENT PRIMARY KEY,
    BusID INT,
    RouteName VARCHAR(255) NOT NULL,
    DepartureTime DATETIME NOT NULL,
    FOREIGN KEY (BusID) REFERENCES Bus(BusID)
);




