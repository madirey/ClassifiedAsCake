<?php
class RecaptchaComponent extends Object
{
    var $publickey = "6LfnFAcAAAAAAMhF4rl67v3dilux67CAvJ7IsnMl";
    var $privatekey = "6LfnFAcAAAAAABqA_hiOuMRMVh-ARwxPU6y9oQot"; 
 
    function startup(&$controller)
    {
        $this->controller = $controller;
    }
 
    function render()
    {
		  App::import('Vendor', 'recaptcha/recaptchalib');
 
        $error = null;
 
        echo recaptcha_get_html($this->publickey, $error);
    }
 
    function verify()
    {
		  App::import('Vendor', 'recaptcha/recaptchalib');
 
        $resp = recaptcha_check_answer ($this->privatekey,
                                  $_SERVER["REMOTE_ADDR"],
                                  $_POST["recaptcha_challenge_field"],
                                  $_POST["recaptcha_response_field"]);
 
        if ($resp->is_valid) {
            return true;
        } else {
            return false;
        }
    }
}
?>
