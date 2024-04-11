<?php

// TODO : à reprendre car cause des bugs

namespace App\src\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSuccesEventSubscriber implements EventSubscriberInterface
{
    //Appel du service Mailer
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    //Cette methode envoie un email a l'utilsateur quand il ce connecte
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        //Acces au user depuis l'objet event
        $user = $event->getAuthenticatedToken()->getUser();
        //Envoyer un email a a l'utilisateur lorsqu'il se connecte
        $mail = (new Email())
            ->to($user->getEmail())
            ->from("admin@admin.fr")
            ->subject("Connexion utilisateur")
            ->text("Connexion au site Symfony 7 E-commerce : ");
        $this->mailer->send($mail);
    }

    //Detection de l'evenement : => quand un utilisateur se connecte
    public static function getSubscribedEvents(): array
    {
        //Appel la methode onLoginSuccessEvent => ci-dessus
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}