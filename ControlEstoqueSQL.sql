CREATE TABLE Gondola (
	Id int AUTO_INCREMENT,
    Nome text(50),
    Codigo text(10),
    PRIMARY KEY (Id)
);

CREATE TABLE Gaveta (
	Id int AUTO_INCREMENT,
    Nome text(50),
    Codigo text(50),
    GondolaId int,
    PRIMARY KEY (Id),
    FOREIGN KEY (GondolaId) REFERENCES Gondola(Id)
);

CREATE TABLE Produto (
	Id int AUTO_INCREMENT,
    Nome text(50),
    Codigo text(50),
    PRIMARY KEY (Id)
);

CREATE TABLE Produto_Gaveta (
	Id int AUTO_INCREMENT,
    Quantidade int,
    ProdutoId int,
    GavetaId int,
    PRIMARY KEY (Id),
    FOREIGN KEY (GavetaId) REFERENCES Gaveta(Id),
    FOREIGN KEY (ProdutoId) REFERENCES Produto(Id)
);

CREATE TABLE Usuario (
	Id int AUTO_INCREMENT,
    Nome text(50),
    Sobrenome text(50),
    Email text(100),
    Senha text(30),
    PRIMARY KEY (Id)
);

