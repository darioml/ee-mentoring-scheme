#!/bin/bash

touch database.sqlite

sqlite3 database.sqlite < struct.sql