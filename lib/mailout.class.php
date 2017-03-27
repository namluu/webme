<?php
class Mailout
{
    public static function send($email, $token)
    {
        $to      = $email;
        $subject = 'Password reset request for '.Config::get('site_name');
        $message = 'Link to reset: '.getUrl('user/resetpassword/'.$token);
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}