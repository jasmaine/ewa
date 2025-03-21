# Meet EWA

EWA is website application for building small or medium size websites and web apps. It stems from the code I created for my own projects. Recently I decided to share it so that others can use it too or want to contribute to develop further together.


## Getting started

Easy installation to get started building with EWA.
1. upload the files on your server
2. setup your webserver and point your document root to the httpdocs folder.
3. open the 'basic.conf.php' file in the app/lib/config folder
4. change the settings matching your information. Do not touch the 'app settings', this might break EWA.
5. Go to the browser type in the url and enjoy! 
6. Time to write your app/website code on the core of EWA, amaze her. 


## Website class view method

Pages and templates are loaded dynamically. Make a new file in de index folder (For Example: /app/index/contact.php). The goal is to keep the logic in the index files and build up the view from the view folder. With the already loaded website class you can request to load the view.

In the new file in the index folder call the following function to load the view:

```php
$app->loadView($view, $data = '');
```

The system will search for a file with the given name as the first param. You can pass data to the view. This can be a single string, boolean, array, object and methods. For example:

```php
$myArray = array('title'=>'Hello World!');
$app->loadView('contact', $myArray);
```

In the view the data is available by simply calling:

`return $data` or `echo $data`

With the data we passed an echo will generate an error. So we can print hello world by the following code:

```php
echo $data['title'];
```

It is recommended only to pass data to build up the view, and leave all the logic in the index files. 

## Database class

The database class is made to supply basic ready to go methods to select, insert, update and delete data from a database.

```php
$db = new Database();
```

In the examples below 'users' is a table in the database. The 'name', 'mail' and 'id' are the rows.

Selecting data from a database is easy and does not need a lot of code:

```php
$db->limit(5)->orderby('name', 'DESC')->get('users', array('name','mail'));

$db->where('id', 1)->get('users', array('name','mail'));
```

If you want every item from the table, just leave the second param empty.

```php
$db->get('users');
```

Example to handle the results:
```php
$db = new Database();

$query = $db->get('users');

if($query->results) {
	
	echo '<h1>Users</h1>';
	echo '<p>You have fetched '.$query->count.' user(s).</p>';
	echo '<table>';
	
	foreach($query->results as $user) {
	
		echo '<tr>';
		echo '<td>'.$user->id.'</td>';
		echo '<td>'.$user->username.'</td>';
		echo '<td>'.$user->mail.'</td>';
		echo '</tr>';
	
	}
	
	echo '</table>';
	
} else {

	echo $query->message;
	
}
```

Insert data in the database:


```php
$db->add('users', array('name'=>'Jan', 'mail'=>'jan@hotmail.com'));
```


Update data in the database:

```php
$db->where('id', 11)->update('user', array('name'=>'Mikey', 'mail'=>'mikey@hotmail.com'));
```

Delete data from the database.

```php
$db->where('id', 11)->remove('users');
```

## Mail class

How to send an e-mail:

```php
$mail = new Mail();

// Full name of the recipient. 
$toName = '';

// E-mail address of the recipient.
$toMail = '';

// E-mail subject
$subject = '';

// This is the mail template name that needs to be loaded
$template = '';

/**
 * This array hold values to replace placeholders in the e-mail template.
 * The keys are written as follows: {name}
 */
$replaceArray = array (
	'name' => 'Firtname Lastname',
	'username' => 'user9',
);

// This will return a boolean
$mail->sendMail($toName, $toMail, $subject, $template, $replaceArray);
```

The e-mail can look like this:

```html 
Hello {name}
<br/><br/>
This is a confirmation about your registration.
You're username is: {username}
<br/><br/>
Kind Regards,
<br/><br/>
Webteam
```

Save a template per language like this: welcome.en.mail.php and for a Dutch version: welcome.nl.mail.php 

## Password Generation

Password validation check and generation is included in the core code:

```php

// The password given by the user (for example via a $_POST var)
$password = '';

/** 
 * Set the minimum length for the password. This field can be left empty.
 * When this field is left out, EWA will use the constant: PASSWORD_LENGTH
 */
$length = 8;

/**
 * By default strict is false.
 * strict: uppercase and lowercase letters, numbers, special characters.
 */
$strict = true;

try {
	
	// Check if the password comply
	Validator::isValidPassword($password, $length, $strict);
	
	// Generate a hash from the password
	$hash = Helper::generatePasswordHash($password);
	
	// For example save it in the DB with the username
	$db = new Database();
	
	$query = $db->add('users', array('username'=>'Jan', 'password'=>$hash));
	
	if($query->results) {
		echo 'New user successfully saved!';
	}
	
	
} catch (Exception $e) {

	echo $e->errorDisplay();
	
}

```

## Dates

Simple tools to quickly return date

```php

// Get the date of tomorrow, standard format is Y-m-d. 
echo 'Tomorrow it is: '.Dates::tomorrow();

// You can also format it how you want the date to be printed. For example you only want to know which day it was yesterday.

echo 'Yesterday it was '.Dates::yesterday('l');

```
