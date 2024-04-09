<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class PageNotFoundExceptionListener
{
    //appel de l'environnement TWIG du contenu de services
    private $twig;
    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        //récupérer les exceptions depuis l'objet event
        $exception = $event->getThrowable();
        // si la requête http aboutit => on envoie la réponse du contrôleur
        if(!$exception  instanceof NotFoundHttpException){
            return;
        }
        // si l'URL est inconnue et donc la requête hthtp échoue => on retourne
        // une vue twig et un statut 404
        $error = $this->twig->render("notifications/page_not_found.html.twig");
        $event->setResponse((new Response())->setContent($error));
    }
}
