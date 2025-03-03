drop schema if exists main cascade;
create schema main;
set schema 'main';

create table _country (
    continent varchar,
    country varchar,
    constraint country_pk primary key (continent, country)
);

create table _city (
    id serial primary key,
    name varchar not null,
    division_1 varchar,
    division_2 varchar,

    lat decimal,
    lng decimal,
    check ((lat is null) = (lng is null)),

    continent varchar not null,
    country varchar not null,
    constraint city_fk_country foreign key (continent, country) references _country
);

-- drop table _import_uscities;
create temp table _import_uscities (
    city varchar not null,
    city_ascii varchar, -- unused
    state_id char(2) not null,
    state_name varchar, -- unused
    country_fips varchar, -- unused
    county_name varchar not null,
    lat decimal not null,
    lng decimal not null,
    population varchar, -- unused
    density varchar, -- unused
    source varchar, -- unused
    military varchar, -- unused
    incorporated varchar, -- unused
    timezone varchar, -- unused
    ranking varchar, -- unused
    zips varchar, -- unused
    id varchar -- unused
);

create table _import_frcommunes (
  code_commune_insee varchar not null,
  nom_commune_postal varchar, -- unused
  code_postal varchar, -- unused
  libelle_acheminement varchar, -- unused
  ligne_5 varchar, -- unused
  latitude decimal,
  longitude decimal,
  check ((latitude is null) = (longitude is null)),
  code_commune varchar, -- unused
  article varchar, -- unused
  nom_commune varchar, -- unused
  nom_commune_complet varchar not null,
  code_departement varchar, -- unused
  nom_departement varchar,
  code_region varchar, -- unused
  nom_region varchar
);
