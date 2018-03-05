<?php
require('PHPMailer.php');
class mail extends PHPMailer {
    
    public $From = 'noreply@domain.com';
    public $FromName = SITETITLE;
    public $WordWrap=75;
    
    
    
    public function send(){
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n",$this->AltBody);
        return parent::send();
               
    }
}
