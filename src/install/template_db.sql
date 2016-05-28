/**
Participatubes 

Création de la base de données vierge.

TODO: Conserver une différence entre emplacement réel et emplacement mod du tube?
TODO: Faut-il versioniser les corrections des tubes avec des tables corrections?
TODO: Opérations de maintenance
TODO: Vérifications polluants types tubes 
TODO: Peut-être utiliser CREATE TABLE c_template.toto (LIKE c_template.mesures INCLUDING ALL);
TODO: Créer un utilisateur en lecture seule pour les connexions de l'application!
*/

\set client_min_messages to warning;
\set ON_ERROR_STOP on;

/* Extension pour les mots de passe */
CREATE EXTENSION IF NOT EXISTS pgcrypto ;

/* Création d'un schéma qui contiendra toutes les fonctions */
DROP SCHEMA IF EXISTS fonctions CASCADE;
CREATE SCHEMA fonctions;

/* Fonction d'insertion d'une image dans un champ bytea */
create or replace function fonctions.bytea_import(p_path text, p_result out bytea) 
	language plpgsql as $$
declare
  l_oid oid;
  r record;
begin
  p_result := '';
  select lo_import(p_path) into l_oid;
  for r in ( select data 
             from pg_largeobject 
             where loid = l_oid 
             order by pageno ) loop
    p_result = p_result || r.data;
  end loop;
  perform lo_unlink(l_oid);
end;$$;
comment on function fonctions.bytea_import(text, out bytea) is '
Insertion d''une image dans un champ bytea
';

/* Création d'un template de schéma d'application */
DROP SCHEMA IF EXISTS c_template CASCADE;
CREATE SCHEMA c_template;

/* Création de la table d'informations sur la campagne */
drop table if exists c_template.info;
create table c_template.info (
	id_info integer not null,
	nom_info text not null,
	valeur_info text not null,
	pj_info BYTEA,
	constraint "pk__c_template.info" primary key (id_info)
);
comment on table c_template.info is '
Informations générales sur la campagne.*
Pour visualiser une image:
SELECT encode(pj_info, ''hex'') FROM c_template.info WHERE id_info = 5;
';

INSERT INTO c_template.info VALUES (1, 'Nom', 'Nice 2025', NULL);
INSERT INTO c_template.info VALUES (2, 'Description', 'Campagne imaginaire de tubes sur Nice.', NULL);
INSERT INTO c_template.info VALUES (3, 'Périodes de mesure', 'Hivert: du 01/01/2025 - 01/02/2025, Eté: du 01/08/2025 - 01/09/2025', NULL);
INSERT INTO c_template.info VALUES (4, 'Participants', 'Air PACA - Etude, GeoScript - Site internet', NULL);
INSERT INTO c_template.info VALUES (5, 'Image principale', 'Tubes en fleurs', (select fonctions.bytea_import('::RACINE::/images/c_template.image_prinicipale.jpg')));

/** FIXME: How to know image directory? */

/* Table des types de tubes */
drop table if exists c_template.tubes_types;
create table c_template.tubes_types (
	type_id integer not null,
	type_nom character varying (20) not null,
	type_description text not null,
	constraint "pk__c_template.tubes_types" primary key (type_id)
);
comment on table c_template.tubes_types is '
Types de tubes utilisés pour évaluer la qualité de l''air.
';

INSERT INTO c_template.tubes_types VALUES (1, 'Tube BTEX', 'Diffusion passive, mesure des COV');
INSERT INTO c_template.tubes_types VALUES (2, 'Tube NO/NO2', 'Mesure le monoxyde et dioxyde d''azote');
INSERT INTO c_template.tubes_types VALUES (3, 'Moyen mobile', 'Multiples instruments de mesure');

/* Table des tubes */
drop table if exists c_template.tubes;
create table c_template.tubes (
	tube_id integer not null,
	tube_nom text not null,
	type_id integer not null,
	tube_validite boolean default true not null,
	tube_validite_desc text default null,
	tube_z double precision default 0 not null,
	tube_image BYTEA default null,
	constraint "pk__c_template.tubes" primary key (tube_id),
	constraint "fk__c_template.tubes_types.type_id" foreign key (type_id)
		references c_template.tubes_types (type_id) ON UPDATE CASCADE ON DELETE RESTRICT
);
SELECT AddGeometryColumn ('c_template', 'tubes', 'geom', 2154, 'POINT', 2);
comment on table c_template.tubes is '
Localisation et description des tubes de la campagne.
Géométrie 2D pour insertion avec QGIS.
';

insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045819.7984035350382328 6297619.06036414951086044)', 2154), 1, 'Moyen Mobile', 3);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045641.40435367764439434 6297333.30708020552992821)', 2154), 2, 'Jetée', 2);	
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045350.81415711343288422 6297572.96848930511623621)', 2154), 3, 'Quai Infernet', 2);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045670.80242651840671897 6297703.10551058128476143)', 2154), 4, 'Quai du Commerce', 2);	
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045469.52082435134798288 6297730.92193152941763401)', 2154), 5, 'Quai d''Entrecasteaux', 2);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045414.83913829573430121 6298184.20440549682825804)', 2154), 6, 'Quai des Docks', 2);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045223.25263328326400369 6298066.34363152831792831)', 2154), 7, 'Quai Papacino', 2);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id, tube_image) values (ST_GeomFromText('POINT(1045427.66299690015148371 6298598.84841374401003122)', 2154), 8, 'Station Arson', 2,	(select fonctions.bytea_import('::RACINE::/images/c_template.station_demo.jpg'))    );	
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045724.19487572065554559 6297794.09171523433178663)', 2154), 9, 'Alicante', 2);	
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045751.73748290026560426 6297742.7397505035623908)', 2154), 10, 'Vigier 4° etg.', 1);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045680.75360146816819906 6297747.68823713250458241)', 2154), 11, 'Pilatte 1 etg.', 1);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045426.15593694767449051 6297878.30503234919160604)', 2154), 12, 'Quai des 2 Emmanuels 4° etg.', 1);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045521.35493409517221153 6298175.90026730950921774)', 2154), 13, 'Stalingrad 1° etg.', 1);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045396.09681344067212194 6298431.55758886970579624)', 2154), 14, 'Bonapart 5° etg.', 1);
insert into c_template.tubes (geom, tube_id, tube_nom, type_id) values (ST_GeomFromText('POINT(1045183.63386900536715984 6297754.15038110595196486)', 2154), 15, 'Quai Lunel 1 etg.', 1);

/* Vue des tubes avec image encodée */  
drop view if exists c_template.tubes_mef;
create view c_template.tubes_mef as 
select 
	tube_id, tube_nom, type_id, 
	tube_validite, tube_validite_desc, tube_z,
	encode(tube_image, 'base64') AS tube_image, 
	geom
from c_template.tubes;

/* Table des polluants mesurés */
DROP table if exists c_template.polluants;
create table c_template.polluants (
	id_polluant integer not null,
	nom_polluant text not null,
	description_polluant text,
	constraint "pk__c_template.polluants" primary key (id_polluant)
);
comment on table c_template.polluants is '
Polluants mesurés.
';

insert into c_template.polluants values (1, 'NO2', 'Dioxydes d''azote');
insert into c_template.polluants values (2, 'COV', 'Composés organiques volatiles');

/* Table des unités */
DROP table if exists c_template.unites;
create table c_template.unites (
	id_unite integer not null,
	nom_unite text not null,
	constraint "pk__c_template.unites" primary key (id_unite)
);
comment on table c_template.unites is '
Unités.
';

INSert into c_template.unites values (1, 'μg/m3');

/* Table des périodes de mesures */
DROP table if exists c_template.mesures_periodes;
create table c_template.mesures_periodes (
	id_periode integer not null,
	nom_periode text not null,
	description_periode text default null,
	constraint "pk__c_template.mesures_periodes" primary key (id_periode)
);
COMMENT ON table c_template.mesures_periodes is '
Périodes de mesures. 
Par défaut été et hivert mais d''autres périodes peuvent-être rajoutées.
';

insert into c_template.mesures_periodes values (1, 'Hivert', 'Du 1er août 2013 au 7 janvier 2014');
insert into c_template.mesures_periodes values (2, 'Eté', 'Du 11 juillet au 8 août 2014');

/* Table des mesures tubes */
DROP table if exists c_template.mesures;
create table c_template.mesures (
	id_polluant integer not null,
	tube_id integer not null,
	id_periode integer not null,
	val double precision default null,
	val_corrigee double precision default null,
	constraint "pk__c_template.mesures" primary key (id_polluant, tube_id, id_periode),
	constraint "fk__c_template.mesures_id_polluant" foreign key (id_polluant) 
		references c_template.polluants (id_polluant) on update cascade on delete restrict,	
	constraint "fk__c_template.mesures_tube_id" foreign key (tube_id) 
		references c_template.tubes (tube_id) on update cascade on delete restrict,
	constraint "fk__c_template.mesures_id_periode" foreign key (id_periode) 
		references c_template.mesures_periodes (id_periode) on update cascade on delete restrict
);
COMMENT ON table c_template.mesures is '
Mesures des tubes.
';

INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 13, 2, 72.6);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 7, 2, 68.5);
/** INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, , 2, 62.4); */
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 15, 2, 53.5);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 6, 2, 47.2);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 14, 2, 42.1);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 4, 2, 41.0);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 3, 2, 41.0);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 5, 2, 39.7);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 12, 2, 39.4);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 8, 2, 39.4);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 2, 2, 35.2);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 11, 2, 34.7);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (1, 10, 2, 28.8);

INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 13, 2, 1.6);
/** INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, , 2, 1.6); */
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 6, 2, 1.2);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 15, 2, 1.1);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 14, 2, 0.9);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 8, 2, 0.7);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 4, 2, 0.7);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 3, 2, 0.5);
INSERT INTO c_template.mesures (id_polluant, tube_id, id_periode, val) VALUES (2, 2, 2, 0.4);

/* Création de la table des rendus */
DROP table if exists c_template.rendus;
create table c_template.rendus (
	id_rendu integer not null,
	nom_rendu text not null,
	description_rendu text not null,
	url_rendu text default null,
	pj_rendu BYTEA default NULL,
	constraint "pk__c_template.rendus" primary key (id_rendu)
);
comment on table c_template.rendus is '
Table des rendus (rapports, études, notes techniques) avec liens ou pièces jointes.
';

insert into c_template.rendus values (
	1, 
	'Évaluation de la qualité de l''air dans le quartier du port, Nice', 
	'Rapport final', 
	'http://www.airpaca.org/sites/paca/files/publications_import/files/140225_AirPACA_Etude_Port_Nice_net.pdf', 
	(select fonctions.bytea_import('::RACINE::/documents/140225_AirPACA_Etude_Port_Nice_net.pdf'))
);

/* Création de la table des privilèges utilisateurs */
DROP table if exists c_template.utilisateurs_privileges;
create table c_template.utilisateurs_privileges (
	id_privilege integer not null,
	nom_privilege text not null,
	constraint "pk__c_template.utilisateurs_privileges" primary key (id_privilege)
);
comment on table c_template.utilisateurs_privileges is '
Privilèges des utilisateurs.
';

insert into c_template.utilisateurs_privileges values (1, 'Administrateur');
insert into c_template.utilisateurs_privileges values (2, 'Public');

/* Création de la table des utilisateurs */
DROP table if exists c_template.utilisateurs;
create table c_template.utilisateurs (
	id_utilisateur integer not null,
	id_privilege integer not null,
	login_utilisateur text not null,
	nom_utilisateur text not null,
	prenom_utilisateur text not null, 
	email_utilisateur text not null,
	password_utilisateur varchar (60),
	constraint "pk__c_template.utilisateurs" primary key (id_utilisateur, id_privilege),
	constraint "fk__c_template.utilisateurs_id_privilege" foreign key (id_privilege) 
		references c_template.utilisateurs_privileges (id_privilege) on update cascade on delete restrict
);
comment on table c_template.utilisateurs is '
Table des utilisateurs et de leur mots de passe.
Pour lire un mot de passe: SELECT crypt(''MonMotDePasse'', password_utilisateur);
';

insert into c_template.utilisateurs values (1, 1, 'admin', 'Roberto', 'Carlos', 'test.user@mail.com', (select crypt('MonMotDePasse', gen_salt('bf',8))));
insert into c_template.utilisateurs values (2, 1, 'public', 'Emilie', 'Jolie', 'test.user@mail.com', (select crypt('MonMotDePasse', gen_salt('bf',8))));

/** TODO: Création d'un schéma de configuration de l'application? */
-- DROP table if exists c_template.config;
-- create table c_template.config (
-- 	id_config integer not null,
-- 	nom_config text not null,
-- 	description_config text not null,
-- 	val text NOT null,	
-- 	constraint "pk__c_template.config" primary key (id_config)
-- );
-- comment on table c_template.config is '
-- Table des paramètres de configuration.
-- ';
-- 
-- insert into c_template.config value (1, 'admin login', 'Login de l''administrateur', 'admin');
-- insert into c_template.config value (1, 'admin password', 'Password de l''administrateur', 'admin');

/* Fonction de création d'un nouveau schéma de campagne avec tables vides */
/** Plus intelligent, outil python qui crée directement un dump du schema template sans données */
-- drop function if exists fonctions.nouvelle_campagne(text);
-- CREATE or replace function fonctions.nouvelle_campagne(text) returns void as $$
-- 
-- 	drop schema if exists c_new cascade;
-- 	create schema c_new;
-- 	
-- 	create table c_new.info (like c_template.info INCLUDING ALL);
-- 	create table c_new.utilisateurs_privileges (like c_template.utilisateurs_privileges INCLUDING ALL);
-- 	create table c_new.utilisateurs (like c_template.utilisateurs INCLUDING ALL);
-- 	alter table c_new.utilisateurs add CONSTRAINT "fk__new.utilisateurs_id_privilege" FOREIGN KEY (id_privilege)
-- 		REFERENCES c_new.utilisateurs_privileges (id_privilege) MATCH SIMPLE ON UPDATE CASCADE ON DELETE RESTRICT;
-- 	create table c_new.unites (like c_template.unites INCLUDING ALL);	
-- 	create table c_new.tubes_types (like c_template.tubes_types INCLUDING ALL);	
-- 	create table c_new.tubes_types (like c_template.tubes_types INCLUDING ALL);	
-- 
-- end $$ language plpgsql;
-- comment on function fonctions.nouvelle_campagne(text) is '
-- Création d''un nouveau schéma de campagne vide.
-- ';



/* Création d'un utilisateur avec les droits de connexion et sélection */
-- create user defaut;
-- alter user  defaut with encrypted password 'participatubes defaut password';
-- GRANT CONNECT ON DATABASE mydb TO xxx;
-- -- This assumes you're actually connected to mydb..
-- GRANT USAGE ON SCHEMA public TO xxx;

/* Opérations de maintenance sur les tables crées */
VACUUM ANALYZE c_template.info;
VACUUM ANALYZE c_template.mesures;
VACUUM ANALYZE c_template.mesures_periodes;
VACUUM ANALYZE c_template.polluants;
VACUUM ANALYZE c_template.rendus;
VACUUM ANALYZE c_template.tubes;
VACUUM ANALYZE c_template.tubes_types;
VACUUM ANALYZE c_template.unites;
VACUUM ANALYZE c_template.utilisateurs;
VACUUM ANALYZE c_template.utilisateurs_privileges;



