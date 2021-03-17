<?php

/**
 * DB Login settings
 */
define("DBHOST", "localhost");
define("DBNAME", "game");
define("DBUSER", "root");
define("DBPASS", "enter");

/**
 * App settings
 */
define("PROCESSED", true);
define("APPLOC", "app");

/*
 * Basic website settings
 */
define("START_PAGE", "home");
define("URI", "http://ewa.project.com");
define("WEBSITE_BASIC_LANG", "nl");
define("WEBSITE_TITLE", "Website Title");
define("WEBSITE_AUTHOR", "Mike Pasarella");

/*
 * SMTP Mail Settings
 */
define("MAIL_HOST", "");
define("MAIL_USER", ""); // SMTP Login User
define("MAIL_PASS", "");
define("MAIL_PORT", 587);
define("MAIL_FROM_ADDRESS", "");
define("MAIL_FROM_NAME", "");

/**
 * Template Settings
 *
 * standard every page will get a header and footer template
 * If pages does not require them, add them to the list below
 * use a ',' to separate the pages
 */
define("TEMPLATE_PLAIN", "404,post,get");