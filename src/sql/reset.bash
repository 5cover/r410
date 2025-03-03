#!/usr/bin/env bash

set -eu

cd "$(dirname "${BASH_SOURCE[0]}")"


psql -v ON_ERROR_STOP=on -d postgres -h "$DB_HOST" -wU "$DB_USER" \
    -c "drop database if exists \"$DB_NAME\"" \
    -c "create database \"$DB_NAME\"" \
    -c "\c \"$DB_NAME\"" \
    -f schema.sql \
    -f populate.sql
