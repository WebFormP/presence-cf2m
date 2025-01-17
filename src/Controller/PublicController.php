<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicController extends AbstractController
{
    # Homepage et Connexion
    #[Route('/', name: 'app_homepage')]
    public function index(AuthenticationUtils $authenticationUtils) : Response
    {
        // En cas d'erreur d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();
        // Pour afficher le dernier utilisateur connecté sur cette machine
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($this->getUser()) {
            $path = $this->redirectToRoute("profile_homepage");
        }
        else {
            $path = $this->render('public/homepage.html.twig', [
                'error' => $error,
            ]);
        }
        return $path;
    }

    # Déconnexion
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout() : void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
