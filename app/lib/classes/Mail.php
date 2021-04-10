<?php
    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mail class
 */
class Mail
{
    private $phpMailer;
    
    /**
     * Class constructor
     *
     * @var private object
     */
    public function __construct()
    {
        $this->phpMailer = new PHPMailer(true);
    }
    
    /**
     * Load the mail template
     *
     * @param string $type
     * @return string $template
     * @return boolean false
     */
    private function loadTemplate($type)
    {
        $userLang = Lang::getUserLang();
        
        $mailTempLoc = BASEPATH.APPLOC.'/template/mails/';
        
        if (file_exists($mailTempLoc.$type.'.'.$userLang.'.mail.php')) {
            $stream = fopen($mailTempLoc.$type.'.'.$userLang.'.mail.php', 'r');
            
            $template = stream_get_contents($stream);
            
            fclose($stream);
            
            return $template;
        } else {
            return false;
        }
    }
    
    /**
     * Replace text in the mail template
     *
     * @param string $type
     * @param array $array
     * @return string $mailTemplate
     */
    private function mailTextReplacer($type, $array = array())
    {
        $mailTemplate = $this->loadTemplate($type);
        
        foreach ($array as $key => $value) {
            $mailTemplate = str_replace('{'.$key.'}', $value, $mailTemplate);
        }
        
        return $mailTemplate;
    }
    
    /**
     * Send email via SMTP by using the PHPmailer class
     *
     * @param string $toName
     * @param string $toAddress
     * @param string $subject
     * @param string $type
     * @param array $array
     * @return boolean false|true
     */
    public function sendMail($toName, $toAddress, $subject, $type, $array = array())
    {
        $htmlMessage = $this->mailTextReplacer($type, $array);
            
        try {
            
            /*
             * Server settings
             * $this->phpMailer->SMTPDebug = SMTP::DEBUG_SERVER;
             * TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above, 587 for STARTTLS
             */
            
            // SMTP settings
            $this->phpMailer->isSMTP();
            $this->phpMailer->Host       = MAIL_HOST;
            $this->phpMailer->SMTPAuth   = true;
            $this->phpMailer->Username   = MAIL_USER;
            $this->phpMailer->Password   = MAIL_PASS;
            $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->phpMailer->Port       = MAIL_PORT;
        
            // Recipients
            $this->phpMailer->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $this->phpMailer->addAddress($toAddress, $toName);
            $this->phpMailer->addReplyTo(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        
            // Content
            $this->phpMailer->isHTML(true);
            $this->phpMailer->Subject = $subject;
            $this->phpMailer->Body    = $htmlMessage;
            // $this->phpMailer->AltBody = $plainMessage;
        
            // Send
            $this->phpMailer->send();
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
