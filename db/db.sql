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
    ArrivalTime DATETIME NOT NULL,
    FOREIGN KEY (BusID) REFERENCES Bus(BusID)
);

CREATE TABLE Ticket (
    TicketID INT AUTO_INCREMENT PRIMARY KEY,
    RouteID INT,
    /*CustomerID INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),*/
    FOREIGN KEY (RouteID) REFERENCES Route(RouteID)
);

CREATE TABLE Seat (
    SeatID INT AUTO_INCREMENT PRIMARY KEY,
    RouteID INT,
    NumSeatsAvailable INT NOT NULL,
    FOREIGN KEY (RouteID) REFERENCES Route(RouteID)
);

/*
CREATE TABLE Payment (

    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(10, 2) NOT NULL,
    PaymentDate DATETIME NOT NULL,
    CustomerID INT
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)

);
*/
-- STORED PROCEDURES --

--INSERT BUS SP
DELIMITER //
CREATE PROCEDURE InsertBus(
    IN p_BusName VARCHAR(30),
    IN p_NumberPlate VARCHAR(30)
)
BEGIN
    INSERT INTO Bus (BusName, NumberPlate) VALUES (p_BusName, p_NumberPlate);
END //
DELIMITER ;


