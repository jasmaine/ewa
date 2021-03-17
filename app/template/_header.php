<?php

// To avoid this template to be loaded as a single file
if (!defined('PROCESSED')) {
    include_once('404.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
   <meta name="description" content="<?php echo DESCRIPTION; ?>" />
   <meta name="keywords" content="<?php echo KEYWORDS; ?>" />
   <meta name="author" http-equiv="author" content="<?php echo WEBSITE_AUTHOR; ?>" />
   <meta name="robots" content="index,follow" />
   <title><?php echo TITLE; ?></title>
   <script type="text/javascript" src="<?php echo URI; ?>/assets/js/jquery.2.min.js"></script>
   <script type="text/javascript" src="<?php echo URI; ?>/assets/js/app.js"></script>
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/jasmine.1.min.css" />
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/app.custom.css" />
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/fonts.css" />
</head>

<body>