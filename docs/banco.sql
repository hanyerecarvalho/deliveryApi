CREATE DATABASE delivery;
USE delivery;

CREATE TABLE clientes (
    idCliente INT PRIMARY KEY AUTO_INCREMENT,
    nomeCliente VARCHAR(45) NOT NULL,
    telefoneCliente VARCHAR(45) NOT NULL
);

CREATE TABLE restaurantes (
    idRestaurante INT PRIMARY KEY AUTO_INCREMENT,
    nomeRestaurante VARCHAR(45) NOT NULL,
    telefoneRestaurante VARCHAR(45) NOT NULL,
    enderecoRestaurante VARCHAR(100) NOT NULL
);

CREATE TABLE produtos (
    idProduto INT PRIMARY KEY AUTO_INCREMENT,
    nomeProduto VARCHAR(45) NOT NULL,
    valorProduto FLOAT NOT NULL,
    idRestaurante INT NOT NULL,

    FOREIGN KEY (idRestaurante)
    REFERENCES restaurantes(idRestaurante)
    ON DELETE CASCADE
);

CREATE TABLE pedidos (
    idPedido INT PRIMARY KEY AUTO_INCREMENT,
    valorTotal FLOAT NOT NULL,
    idCliente INT NOT NULL,
    idRestaurante INT NOT NULL,

    FOREIGN KEY (idCliente)
    REFERENCES clientes(idCliente)
    ON DELETE CASCADE,

    FOREIGN KEY (idRestaurante)
    REFERENCES restaurantes(idRestaurante)
    ON DELETE CASCADE
);

CREATE TABLE itens_pedidos (
    idItemPedido INT PRIMARY KEY AUTO_INCREMENT,
    quantidade INT NOT NULL,
    idPedido INT NOT NULL,
    idProduto INT NOT NULL,

    FOREIGN KEY (idPedido)
    REFERENCES pedidos(idPedido)
    ON DELETE CASCADE,

    FOREIGN KEY (idProduto)
    REFERENCES produtos(idProduto)
    ON DELETE CASCADE
);

INSERT INTO clientes (nomeCliente, telefoneCliente)
VALUES 
('João Silva', '11999990001'),
('Maria Oliveira', '11999990002'),
('Carlos Souza', '11999990003');

INSERT INTO restaurantes (nomeRestaurante, telefoneRestaurante, enderecoRestaurante)
VALUES
('Pizza Express', '1133334444', 'Rua das Flores, 100'),
('Burger House', '1144445555', 'Av. Paulista, 500'),
('Sushi Master', '1155556666', 'Rua Japão, 200');

INSERT INTO produtos (nomeProduto, valorProduto, idRestaurante)
VALUES
('Pizza Calabresa', 45.90, 1),
('Pizza Portuguesa', 49.90, 1),
('Hamburguer Artesanal', 32.50, 2),
('Batata Frita', 18.00, 2),
('Combo Sushi', 59.90, 3),
('Temaki Salmão', 28.90, 3);

INSERT INTO pedidos (valorTotal, idCliente, idRestaurante)
VALUES
(63.90, 1, 1),
(50.50, 2, 2),
(88.80, 3, 3);

INSERT INTO itens_pedidos (quantidade, idPedido, idProduto)
VALUES
(1, 1, 1),
(1, 1, 2),
(1, 2, 3),
(1, 2, 4),
(1, 3, 5),
(1, 3, 6);