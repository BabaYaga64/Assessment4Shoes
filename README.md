Shoe Stores and Shoe Brands

March 27th, 2015

Description

This program lists shoe stores and the brands of shoes they carry. This is a many to many relationship in SQL.

Database Commands

****************
As you create your tables, copy all commands used in psql into your readme file.

Guest=# CREATE DATABASE shoes;
CREATE DATABASE

Guest=# \c shoes;
You are now connected to database "shoes" as user "Guest".

shoes=# CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
CREATE TABLE
shoes=#

shoes=# CREATE TABLE brands (id serial PRIMARY KEY, name varchar);
CREATE TABLE
shoes=#

shoes=# CREATE TABLE shoes_brands (id serial PRIMARY KEY, store_id int, brand_id int);
CREATE TABLE
shoes=#

shoes=# CREATE DATABASE shoes_test WITH TEMPLATE shoes;
CREATE DATABASE
shoes=# \c shoes_test;
You are now connected to database "shoes_test" as user "Guest".
shoes_test=# 






***************

Technology

PHP
Silex
Twig
PostgreSQL
PHPUnit
Test Driven Development
Composer
License

The MIT License (MIT)

Copyright (c) 2015 Bojana Skarich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.