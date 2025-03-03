set schema 'main';

begin;

/*WbImport
    -file='data/Countries-Continents.csv'
    -delimiter=','
    -quoteChar='"'
    -quoteAlways
    -emptyStringIsNull=false
    -table=_country;*/
\copy _country from 'data/Countries-Continents.csv' csv header delimiter ',' quote '"' null '';

commit;

begin;

/*
WbImport
    -file='data/uscities.csv'
    -delimiter=','
    -quoteChar='"'
    -quoteAlways
    -emptyStringIsNull=false
    -table=_import_uscities;
*/
\copy _import_uscities from 'data/uscities.csv' csv header delimiter ',' quote '"' null '';

insert into
    _city (continent, country, name, division_2, division_1, lat, lng)
select
    'North America' continent,
    'US' country,
    city name,
    county_name division_2,
    state_id division_1,
    lat,
    lng
from
    _import_uscities;

commit;

begin;

/*WbImport
    -file='data/fr-communes-departement-region.csv'
    -delimiter=','
    -emptyStringIsNull=false
    -table=_import_frcommunes;*/
\copy _import_frcommunes from 'data/fr-communes-departement-region.csv' csv header delimiter ',' quote '"' null '';

insert into
    _city (continent, country, name, division_2, division_1, lat, lng)
select
    'Europe' continent,
    'France' country,
    nom_commune_complet name,
    nom_departement division_2,
    nom_region division_1,
    latitude lat,
    longitude lng
from _import_frcommunes;

commit;