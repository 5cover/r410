#!/usr/bin/env bash

# $ set -a && . .env.source

set -eu

cd "$(dirname "${BASH_SOURCE[0]}")"

pushd ..

scp -r sql "debian@413.ventsdouest.dev:/tmp/sql/"

popd

declare database_default_hostname database_default_database database_default_username database_default_password database_default_port

# shellcheck disable=SC2087
ssh debian@413.ventsdouest.dev <<EOF
    sudo docker cp /tmp/sql postgresdb:/sql
    sudo docker exec -w /sql postgresdb psql \
    -v ON_ERROR_STOP=on "postgres://$database_default_username:$database_default_password@$database_default_hostname:$database_default_port/postgres" \
    -c "drop database if exists $database_default_database" \
    -c "create database $database_default_database" \
    -c "\c $database_default_database" \
    -f schema.sql \
    -f populate.sql
EOF