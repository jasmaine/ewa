<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, height=800, initial-scale=1, user-scalable=no">
   <meta name="author" http-equiv="author" content="<?php echo WEBSITE_AUTHOR; ?>" />
   <meta name="robots" content="noindex" />
   <title>404 | <?php echo TITLE; ?></title>
   <script type="text/javascript" src="<?php echo URI; ?>/assets/js/jquery.2.min.js"></script>
   <script type="text/javascript" src="<?php echo URI; ?>/assets/js/app.js"></script>
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/jasmine.1.min.css" />
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/fonts.css" />
   <link rel="stylesheet" type="text/css" media="all" href="<?php echo URI; ?>/assets/css/app.custom.css" />
</head>

<body>
   <div class="container">
      <div class="grid">
         <div class="width-1-1">
            <div class="pad-40">
               <div class="extreme light">404</div>
               <div class="medium light"><?php echo trans('page_not_found'); ?><br />
                  <a href="home" class="text-cyan small"><?php echo trans('back_to_home'); ?></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>