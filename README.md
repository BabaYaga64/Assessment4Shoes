#Shoe Stores and Shoe Brands

##March 27th, 2015

###Description

This program lists shoe stores and the brands of shoes they carry, illustrating a many-to-many relationship in SQL. One can view all of the brands that a particular store carries, and a user can add their own brand to the store. Likewise, a user can view all of the stores that a certain brand can be found in, and can add their own store to the list.

Silex and Twig software is used to display the user interface for the app. 

***************

###Setup Instructions

1. Clone git repository from remote repository on GitHubs

2. Start PHP server in the web directory of your project folder. 

3. Point your browser to your root path. 

4. Create two databases in psql: shoes and shoes_test. Connect to each of these and then import the .sql files from the remote repository to your local machine. 

5. Install the required dependencies via your composer.json file and Composer

6. Start your app by opening root path in browser.



***************

###Technology

PHP
Silex
Twig
PostgreSQL
PHPUnit
Test Driven Development
Composer
License

###Database Commands

****************
As you create your tables, copy all commands used in psql into your readme file.

Guest=# CREATE DATABASE shoes;
CREATE DATABASE

Guest=# \c shoes;
You are now connected to database "shoes" as user "Guest".

shoes=# CREATE TABLE brands (id serial PRIMARY KEY, name varchar);
CREATE TABLE
shoes=#

shoes=# CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
CREATE TABLE
shoes=#

shoes=# CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int, );
CREATE TABLE
shoes=#

shoes=# CREATE DATABASE shoes_test WITH TEMPLATE shoes;
CREATE DATABASE
shoes=# \c shoes_test;
You are now connected to database "shoes_test" as user "Guest".
shoes_test=#

shoes_test=# \c shoes;
You are now connected to database "shoes" as user "Guest".
shoes=#

/* to save and upload your databases, run the following in bash:

pg_dump shoes -f shoes.sql
pg_dump shoes_test -f shoes_test.sql

to import, run the following in psql:

/i shoes.sql;
/i shoes_test.sql;

*/


###The MIT License (MIT)

Copyright (c) 2015 Bojana Skarich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
