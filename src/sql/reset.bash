#!/usr/bin/env bash

# $ set -a && . .env.source

set -eu

cd "$(dirname "${BASH_SOURCE[0]}")"

# shellcheck disable=SC2087

scp . "debian@413.ventsdouest.dev:/tmp/sql"

ssh debian@413.ventsdouest.dev sudo docker exec -iw / postgresdb psql \
    -v ON_ERROR_STOP=on "postgres://$PGUSER:$PGPASS@$PGHOST:$PGPORT/postgres" \
    -c "\"drop database if exists $PGDATABASE\"" \
    -c "\"create database $PGDATABASE\"" \
    -c "\"\c $PGDATABASE\"" \
    -f schema.sql \
    -f populate.sql
