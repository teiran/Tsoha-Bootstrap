INSERT INTO Huutaja (nimi, salasana) VALUES ('Kalle', 'Kalle123');
INSERT INTO Huutaja (nimi, salasana) VALUES ('Henri', 'Henri123');
INSERT INTO Asia (nimi, hinta, huutoaika, lisätty) VALUES ('Tuoli', 200, '1-12-2017', '20-12-2017');
INSERT INTO AsiaKategoriat (nimi) VALUES ('Huonekalu');

INSERT INTO Valitaulu(luoja_id, Asia_id, Huutaja_id) VALUES (1, 2, 1);
