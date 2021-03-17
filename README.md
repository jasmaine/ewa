# Meet EWA

EWA is een website applicatie. Het is gebouwd als antwoord op de grote frameworks. Want niet iedere website of web app heeft een groot framework nodig. 

Daarnaast is het ook een persoonlijk project waarmee ik mezelf ontwikkel als php programmeur.

## Methods

### Database class

The database class is made to supply basic anready to go methods to select, insert, update and delete data from a mysql database. It is build on the mysqli method.
To start innitiate by creating an object:

`$mysql = new Mysql();`

**SELECT**

Selecting data from a database is easy and does not need a lot of code.

`$mysql->get('tabel','row1,row2,row3');`

**SELECT WHERE**

You can stack the where state on top of the get method.

`$mysql->where('id',1)->get('tabel','row1,row2,row3');`
