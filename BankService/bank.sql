CREATE TABLE customer ( id INT, `name` CHAR(255), balance INT, PRIMARY KEY (id));
INSERT INTO customer VALUES ('0', 'tayo', 1000);
INSERT INTO customer VALUES ('1', 'tayi', 0);

CREATE TABLE tx ( sender_id INT, receiver_id INT, tx_time DATETIME, PRIMARY KEY (sender_id, receiver_id, tx_time));