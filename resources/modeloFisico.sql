CREATE TABLE historico (
    id_historico SERIAL PRIMARY KEY,
    id_pessoa int,
    data date
);

CREATE TABLE pessoa (
    id_pessoa SERIAL PRIMARY KEY,
    nome text
);

CREATE TABLE indisponibilidade (
    id_indisponibilidade SERIAL PRIMARY KEY,
    id_pessoa int,
    data date
);

CREATE TABLE quantidade_lavada (
    id_quantidade_lavada SERIAL PRIMARY KEY,
    id_pessoa int,
    quantidade int
);

CREATE TABLE indisponibilidade_semanal (
    id_indisponibilidade_semanal SERIAL PRIMARY KEY,
    id_pessoa INT,
    segunda BOOLEAN DEFAULT FALSE,
    terca BOOLEAN DEFAULT FALSE,
    quarta BOOLEAN DEFAULT FALSE,
    quinta BOOLEAN DEFAULT FALSE,
    sexta BOOLEAN DEFAULT FALSE,
    sabado BOOLEAN DEFAULT FALSE,
    domingo BOOLEAN DEFAULT FALSE
);

CREATE OR REPLACE FUNCTION atualiza()
RETURNS trigger AS $triggerAtualiza$
BEGIN
    UPDATE quantidade_lavada SET quantidade = quantidade - 1 WHERE id_pessoa = old.id_pessoa;
    UPDATE quantidade_lavada SET quantidade = quantidade + 1 WHERE id_pessoa = new.id_pessoa;
    RETURN NEW;
END;
$triggerAtualiza$ LANGUAGE plpgsql; 

CREATE OR REPLACE FUNCTION insere()
RETURNS trigger AS $triggerInsere$
BEGIN
    UPDATE quantidade_lavada SET quantidade = quantidade + 1 WHERE id_pessoa = new.id_pessoa;
    RETURN NEW;
END;
$triggerInsere$ LANGUAGE plpgsql; 

CREATE TRIGGER trigger_quantidade_lavada_insert
  AFTER INSERT ON historico
  FOR EACH ROW
  EXECUTE PROCEDURE insere();

CREATE TRIGGER trigger_quantidade_lavada_update
  AFTER UPDATE ON historico
  FOR EACH ROW
  EXECUTE PROCEDURE atualiza();
  
INSERT INTO pessoa(nome) values ('André'), ('Duilio'), ('Victor'), ('Wagner');
INSERT INTO quantidade_lavada(id_pessoa, quantidade) values (1,0), (2,0), (3,0), (4,0);

INSERT INTO indisponibilidade_semanal(id_pessoa, terca, quinta) VALUES (2, FALSE, TRUE), (1, TRUE, FALSE);
alter table indisponibilidade_semanal add unique (id_pessoa);

ALTER TABLE historico ADD FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa);
ALTER TABLE indisponibilidade ADD FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa);
ALTER TABLE indisponibilidade_semanal ADD FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa);
ALTER TABLE quantidade_lavada ADD FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa);

CREATE OR REPLACE FUNCTION deleta()
RETURNS trigger AS $triggerDeleta$
BEGIN
    UPDATE quantidade_lavada SET quantidade = quantidade - 1 WHERE id_pessoa = old.id_pessoa;
    RETURN OLD;
END;
$triggerDeleta$ LANGUAGE plpgsql; 

CREATE TRIGGER trigger_quantidade_lavada_delete
  AFTER DELETE ON historico
  FOR EACH ROW
  EXECUTE PROCEDURE deleta();

