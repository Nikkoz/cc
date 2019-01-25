<?php
namespace core\services\contact;

use core\forms\ContactForm;
use yii\mail\MailerInterface;

class ContactService
{
    private $supportEmail;
    private $adminEmail;
    private $mailer;

    public function __construct($supportEmail, $adminEmail, MailerInterface $mailer)
    {
        $this->supportEmail = $supportEmail;
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function send(ContactForm $form): void
    {
        $sent = $this->mailer->compose()
            ->setTo($this->supportEmail)
            ->setFrom($this->adminEmail)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();

        if(!$sent) {
            throw new \RuntimeException('Sending error.');
        }
    }
}