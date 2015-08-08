<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/10/14
 * Time: 11:47 PM
 */

namespace Fototea\Util;
use Fototea\Config\FConfig;
use PHPMailer;

class FMailer {

    private $phpMailer;
    public $toEmail;
    public $toName;
    public $subject;
    public $content;

    function __construct() {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Set the hostname of the mail server
        $mail->Host = FConfig::getValue('email_smtp_url');

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = FConfig::getValue('email_smtp_user');

        //Password to use for SMTP authentication
        $mail->Password = FConfig::getValue('email_smtp_pass');

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = FConfig::getValue('email_smtp_port');

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        // Set encoding
        $mail->CharSet = 'UTF-8';

        // Set email format to HTML
        $mail->isHTML(true);

        //Set who the message is to be sent from
        $mail->setFrom(FConfig::getValue('email_sender_email'), FConfig::getValue('email_sender_name'));

        $this->phpMailer = $mail;
    }

    /**
     * Set who the message is to be sent to
     * @param $receivers
     */
    public function setReceivers($receivers){
        foreach ($receivers as $receiver){
            if (isset($receiver['name'])){
                //Set who the message is to be sent to
                $this->phpMailer->addAddress($receiver['email'], $receiver['name']);
            } else {
                $this->phpMailer->addAddress($receiver['email']);
            }
        }
    }

    /**
     * Set who the message is to be sent to like CC
     * @param $receivers
     */
    public function setCC($receivers){
        foreach ($receivers as $receiver){
            if (isset($receiver['name'])){
                $this->phpMailer->addCC($receiver['email'], $receiver['name']);
            } else {
                $this->phpMailer->addCC($receiver['email']);
            }
        }
    }

    /**
     * Set who the message reply to
     * @param $receivers
     */
    public function setReplyTo($receivers){
        foreach ($receivers as $receiver){
            if (isset($receiver['name'])){
                $this->phpMailer->addReplyTo($receiver['email'], $receiver['name']);
            } else {
                $this->phpMailer->addReplyTo($receiver['email']);
            }
        }
    }

    /**
     * Set who the message is to be sent to like BCC
     * @param $receivers
     */
    public function setBCC($receivers){
        foreach ($receivers as $receiver){
            if (isset($receiver['name'])){
                $this->phpMailer->addBCC($receiver['email'], $receiver['name']);
            } else {
                $this->phpMailer->addBCC($receiver['email']);
            }
        }
    }

    /**
     * Set attachments
     * @param $attachments
     */
    public function setAttachments($attachments){
        foreach ($attachments as $attachment){
            if (isset($attachment['name'])){
                $this->phpMailer->addAttachment($attachment['file'], $attachment['name']);
            } else {
                $this->phpMailer->addAttachment($attachment['file']);
            }
        }
    }

    /**
     * Set subject and body and then send the email
     * @param $subject
     * @param $body
     */
    public function sendEmail($subject, $body){

        //Set the subject line
        $this->phpMailer->Subject = $subject;

        // Set html message body
        $this->phpMailer->Body = $body;

        //send the message, check for errors
        if (!$this->phpMailer->send()) {
            return false;
        } else {
            return true;
        }

    }

    public function replaceParameters($params, $body){
        foreach ($params as $key => $param){
            $body = str_replace('{{' . $key . '}}', $param, $body);
        }

        return $body;
    }

}