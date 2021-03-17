<?php

/*
 * DB Login settings
 *
 */
 
define("DBHOST", "localhost");
define("DBNAME", "");
define("DBUSER", "");
define("DBPASS", "");

/**
 * App settings
 *
 */
define("PROCESSED", true);
define("APPLOC", "app");

/*
 * Basic website settings
 *
 */
define("START_PAGE", "home");
define("URI", "http://ewa.project.com");
define("WEBSITE_BASIC_LANG", "nl");
define("WEBSITE_TITLE", "Website Title");
define("WEBSITE_AUTHOR", "Mike Pasarella");

/*
 * SMTP Mail Settings
 *
 */
define("MAIL_HOST", "smtp.example.com"); // smtp server
define("MAIL_USER", "mail@example.com"); // smtp server user to login with
define("MAIL_PASS", "password"); // smtp server pass
define("MAIL_PORT", 587); // smtp server port
define("MAIL_FROM_ADDRESS", "sendermail@example.omc");
define("MAIL_FROM_NAME", "Sender Name");

/*
 * Template Settings
 *
 * standard every page will get a header and footer template
 * If pages does not require them, add them to the list below
 * use a ',' to seperate the pages
 *
 */
define("TEMPLATE_PLAIN", "404,post,get");
