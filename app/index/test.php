<?php
    
$mail = new Mail();

$replaceArray = array(
    '%%NAME%%' => 'Mike',
    '%%TIMESTAMP%%' => time(),
    '%%FROM%%' => MAIL_FROM_NAME
);
 
if ($mail->sendMail('Mike', 'mike@pasarella.eu', 'This is a Subject', 'test', $replaceArray)) {
    echo'<h1>E-mail send!</h1>';
}
