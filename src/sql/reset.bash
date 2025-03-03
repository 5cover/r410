#!/usr/bin/env bash

set -eu

cd "$(dirname "${BASH_SOURCE[0]}")"

db=r4c10_geographie

psql -d postgres -v ON_ERROR_STOP=on -h localhost -wU postgres \
    -c "drop database if exists $db" \
    -c "create database $db" \
    -c "\c $db" \
    -f schema.sql \
    -f populate.sql
