<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Bundle\MonologBundle\SwiftMailer\MessageFactory;
use Twig\Environment;

class ContactNotification {


    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {


        $this->environment = $environment;
        $this->mailer = $mailer;
    }


    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message( "Agence : " . $contact->getProperty()->getTitle()))
            ->setFrom('simon.chardon@yahoo.fr')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->environment->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);

    }
}