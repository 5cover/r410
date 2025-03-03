drop schema if exists main cascade;
create schema main;
set schema 'main';

-- création de la table des auteurs
create table _authors (
    id serial primary key,
    dblp_key varchar(255) unique not null,
    name varchar not null,
    affiliation varchar,
    country varchar,
    orcid varchar(50) unique
);

-- création de la table des institutions
create table _institutions (
    id serial primary key,
    name varchar not null,
    acronym varchar,
    country varchar not null,
    city varchar,
    latitude float,
    longitude float
);

-- création de la table des publications
create table _publications (
    id serial primary key,
    dblp_key varchar(255) unique not null,
    title varchar not null,
    year int check (year > 1900 and year <= extract(year from current_date)),
    venue varchar,
    doi varchar(100) unique,
    url varchar
);

-- table de relation "plusieurs à plusieurs" entre auteurs et publications
create table _authorships (
    author_id int references _authors on delete cascade,
    publication_id int references _publications on delete cascade,
    primary key (author_id, publication_id)
);

-- table pour gérer l'historique des affiliations des auteurs
create table _affiliations (
    author_id int references _authors on delete cascade,
    institution_id int references _institutions on delete cascade,
    start_year int check (start_year > 1900),
    end_year int check (end_year is null or end_year > start_year),
    primary key (author_id, institution_id, start_year)
);

-- table pour suivre les collaborations entre laboratoires via les publications
create table _collaborations (
    institution1_id int references _institutions on delete cascade,
    institution2_id int references _institutions on delete cascade,
    publication_id int references _publications on delete cascade,
    primary key (institution1_id, institution2_id, publication_id)
);


-- test tables

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

-- import tables

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
