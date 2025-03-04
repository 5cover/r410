#!/usr/bin/env bash

# $ set -a && . .env.source

set -eu

cd "$(dirname "${BASH_SOURCE[0]}")"

# shellcheck disable=SC2087

scp . "debian@413.ventsdouest.dev:/tmp/sql"

declare database_default_hostname database_default_database database_default_username database_default_password database_default_port

ssh debian@413.ventsdouest.dev sudo docker exec -iw / postgresdb psql \
    -v ON_ERROR_STOP=on "postgres://$database_default_username:$database_default_password@$database_default_hostname:$database_default_port/postgres" \
    -c "\"drop database if exists $database_default_database\"" \
    -c "\"create database $database_default_database\"" \
    -c "\"\c $database_default_database\"" \
    -f schema.sql \
    -f populate.sql
