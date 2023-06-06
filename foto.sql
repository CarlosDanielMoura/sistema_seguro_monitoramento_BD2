CREATE TABLE endereco (
    id_endereco serial PRIMARY KEY,
    rua varchar CHECK (rua <> ''),
    numero int CHECK (numero > 0),
    bairro varchar CHECK (bairro <> ''),
    tipo_endereco varchar CHECK (tipo_endereco IN ('Residencial', 'Comercial')),
    complemento varchar,
	id_pessoa int,
	cep varchar,
	cidade varchar,
	uf varchar,
	img_comprovante_end bytea,
	dir_imagem varchar,
    FOREIGN KEY (id_pessoa) REFERENCES Cliente(id)
);
