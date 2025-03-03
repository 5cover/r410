<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $db->simpleQuery("set schema 'main'");

        return view('welcome_message', [
            'q1' => $db->query(<<<SQL
select
    country,
    count(*) n_cities
from
    _city
group by
    country;
SQL)->getResult(),
            'q2' => $db->query(<<<SQL
select
    continent,
    count(*) n_countries
from
    _country
group by
    continent;
SQL)->getResult(),
            'q3' => $db->query(<<<SQL
select
    continent,
    count(*) n_cities
from
    _city
group by
    continent;
SQL)->getResult(),
            'q4' => $db->query(<<<SQL
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
SQL)->getRow(),
            'q5' => $db->query(<<<SQL
select
    avg(n_cities)
from
    (
        select
            count(*) n_cities
        from
            _city
        group by
            continent
    ) as n;
SQL)->getRow(),
            'q6' => $db->query(<<<SQL
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
SQL)->getRow(),
        ]);
    }
}
