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
drop table if exists c_template.tubes_typos;
create table c_template.tubes_typos (
	typo_id integer not null,
	typo_nom character varying (20) not null,
	typo_description text not null,
	constraint "pk__c_template.tubes_typos" primary key (typo_id)
);
comment on table c_template.tubes_typos is '
Typologie des sites de mesure.
';

INSERT INTO c_template.tubes_typos VALUES (1, 'T', 'Trafic');
INSERT INTO c_template.tubes_typos VALUES (2, 'U', 'Urbain');
INSERT INTO c_template.tubes_typos VALUES (3, 'R', 'Rural');
INSERT INTO c_template.tubes_typos VALUES (4, 'P', 'Proximité');

/* Table des tubes */
drop table if exists c_template.tubes;
create table c_template.tubes (
	tube_id integer not null,
	tube_nom text not null,
	tube_ville text not null,
	typo_id integer not null,
	tube_validite boolean default true not null,
	tube_validite_desc text default null,
	tube_z double precision default 0 not null,
	tube_image BYTEA default null,
	constraint "pk__c_template.tubes" primary key (tube_id),
	constraint "fk__c_template.tubes_typo.typo_id" foreign key (typo_id)
		references c_template.tubes_typos (typo_id) ON UPDATE CASCADE ON DELETE RESTRICT
);
SELECT AddGeometryColumn ('c_template', 'tubes', 'geom', 2154, 'POINT', 2);
comment on table c_template.tubes is '
Localisation et description des tubes de la campagne.
Géométrie 2D pour insertion avec QGIS.
';

create temporary table tubes_tmp (
	id integer not null,
	typo text not null,
	nom text not null,
	ville text not null,
	x double precision,
	y double precision
);
copy tubes_tmp 
from '::RACINE::/documents/tubes.csv'
with delimiter as ',' null as '' csv header;

INSERT INTO c_template.tubes
SELECT 
	id,
	nom,
	ville,
	(select typo_id from c_template.tubes_typos WHERE typo_nom = typo),
	true,
	null,
	0,
	(select fonctions.bytea_import('::RACINE::/images/c_template.station_demo.jpg')),
	(select ST_SetSRID(ST_MakePoint(x, y), 2154))
From tubes_tmp;

/* Vue des tubes avec image encodée */  
drop view if exists c_template.tubes_mef;
create view c_template.tubes_mef as 
select 
	tube_id, tube_nom, tube_ville, typo_id, typo_nom, 
	tube_validite, tube_validite_desc, tube_z,
	encode(tube_image, 'base64') AS tube_image, 
	geom
from c_template.tubes as a
left join c_template.tubes_typos as b using (typo_id);

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

insert into c_template.polluants values (1, 'NO2', '(µg/m3)');
insert into c_template.polluants values (2, 'Benzène', '(µg/m3)');
insert into c_template.polluants values (3, 'Toluène', '(µg/m3)');
insert into c_template.polluants values (4, 'Ethylbenzène', '(µg/m3)');
insert into c_template.polluants values (5, 'm+p-xylène', '(µg/m3)');
insert into c_template.polluants values (6, 'o-xylène', '(µg/m3)');

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
insert into c_template.mesures_periodes values (3, 'Correction partielle', '');
insert into c_template.mesures_periodes values (4, 'Correction complète', '');

/* Table des mesures tubes */
DROP table if exists c_template.mesures;
create table c_template.mesures (
	id_polluant integer not null,
	tube_id integer not null,
	id_periode integer not null,
	id_unite integer not null,
	val double precision default null,
	val_corrigee double precision default null,
	constraint "pk__c_template.mesures" primary key (id_polluant, tube_id, id_periode),
	constraint "fk__c_template.mesures_id_polluant" foreign key (id_polluant) 
		references c_template.polluants (id_polluant) on update cascade on delete restrict,	
	constraint "fk__c_template.mesures_tube_id" foreign key (tube_id) 
		references c_template.tubes (tube_id) on update cascade on delete restrict,
	constraint "fk__c_template.mesures_id_periode" foreign key (id_periode) 
		references c_template.mesures_periodes (id_periode) on update cascade on delete restrict,
	constraint "fk__c_template.mesures_id_unite" foreign key (id_unite) 
		references c_template.unites (id_unite) on update cascade on delete restrict		
);
COMMENT ON table c_template.mesures is '
Mesures des tubes.
';

copy c_template.mesures 
from '::RACINE::/documents/mes_no2.csv'
with delimiter as ',' null as '' csv header;

copy c_template.mesures 
from '::RACINE::/documents/mes_btex.csv'
with delimiter as ',' null as '' csv header;

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



