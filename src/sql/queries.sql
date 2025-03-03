set schema 'main';

-- Le nombre de villes par pays 
select
    country,
    count(*) n_cities
from
    _city
group by
    country;

-- Le nombre de pays par continent
select
    continent,
    count(*) n_countries
from
    _country
group by
    continent;

-- Le nombre de villes par continent
select
    continent,
    count(*) n_cities
from
    _city
group by
    continent;

-- Le nombre maximum de villes par pays 
select
    country,
    count(*) as n_cities
from
    _city
group by
    country
order by
    n_cities desc
limit
    1;

-- Le nombre moyen de villes par continent
select
    avg(n)
from
    (
        select
            count(*) n_cities
        from
            _city
        group by
            continent
    ) as n;

    
-- Le nombre maximum de pays par continent
select
    continent,
    count(*) n_countries
from
    _country
group by
    continent
order by
    n_countries desc
limit
    1;
