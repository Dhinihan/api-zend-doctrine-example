CREATE TABLE example (id UUID NOT NULL, description VARCHAR(60) NOT NULL, PRIMARY KEY(id));
COMMENT ON COLUMN example.id IS '(DC2Type:uuid)';
CREATE TABLE customer (id UUID NOT NULL, name VARCHAR(60) NOT NULL, cpf CHAR(11) NOT NULL, PRIMARY KEY(id));
COMMENT ON COLUMN customer.id IS '(DC2Type:uuid)';
