CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY, 
  nimi varchar(50) NOT NULL, 
  salasana varchar(50) NOT NULL,
  tili varchar(30),
  kate varchar(30),
  yllapitaja boolean DEFAULT FALSE
);
CREATE TABLE Valitaulu(
  id SERIAL PRIMARY KEY,
  luoja_id INTEGER,
  Asia_id INTEGER,
  Huutaja_id INTEGER
);

CREATE TABLE Asia(
  id SERIAL PRIMARY KEY, 
  nimi varchar(50) NOT NULL,
  hinta INTEGER NOT NULL,
  huutoaika DATE NOT NULL,
  lisatty DATE NOT NULL,
  hintaosta INTEGER NOT NULL,
  ostettu BOOLEAN DEFAULT FALSE,
  kuvaus varchar(200)
);

CREATE TABLE Valitustaulu2(
  id SERIAL PRIMARY KEY,
  asia_id INTEGER REFERENCES Asia(id),
  AsiaKategoria_id INTEGER REFERENCES AsiaKategoria(id)
);

CREATE TABLE AsiaKategoriat(
  id SERIAL PRIMARY KEY,
  nimi varchar(50) NOT NULL,
  kuvaus varchar(200)
);
  
