# Meet EWA

EWA is een website applicatie. Het is gebouwd als antwoord op de grote frameworks. Want niet iedere website of web app heeft een groot framework nodig. 

Daarnaast is het ook een persoonlijk project waarmee ik mezelf ontwikkel als php programmeur.

## Methods

### Database class

The database class is made to supply basic ready to go methods to select, insert, update and delete data from a mysql database. It is build on the [php mysqli extension.](https://www.php.net/manual/en/book.mysqli.php) To start innitiate by creating an object:

`$mysql = new Mysql();`

**SELECT**

Selecting data from a database is easy and does not need a lot of code.

`$mysql->get('table','row1,row2,row3');`

If you want every item from the table, just leave the second param empty.

`$mysql->get('table');`


**SELECT WHERE**

You can stack the where method on top of the get method.

`$mysql->where('id',1)->get('tabel','row1,row2,row3');`
