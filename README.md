# Meet EWA

EWA is website application for building small or medium size websites and web apps. It stems from the code I created for my own projects. Recently I decided to share it so that others can use it too or want to contribute to develop further together.

## TODO
* Building a language switch
* Breadcrumb method
* Adding a general var validation from user input
* Making a basic start page in the 'home' view
* Writing installation/usage guide (already started below)

## Methods

### Database class

The database class is made to supply basic ready to go methods to select, insert, update and delete data from a database.

`$db = new Database();`

In the examples below 'users' is a table in the database. The 'name', 'mail' and 'id' are the rows.

**SELECT**

Selecting data from a database is easy and does not need a lot of code.

`$db->limit(5)->orderby('name', 'DESC')->get('users', array('name','mail'));`

`$db->where('id', 1)->get('users', array('name','mail'));`

If you want every item from the table, just leave the second param empty.

`$db->get('users');`


**INSERT**


`$db->add('users', array('name'=>'Jan', 'mail'=>'jan@hotmail.com'));`


**UPDATE**

`$db->where('id', 11)->update('user', array('name'=>'Mikey', 'mail'=>'mikey@hotmail.com'));`

**DELETE**

`$db->where('id', 11)->remove('users');`