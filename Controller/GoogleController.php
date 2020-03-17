<?php

namespace retItalia\AuthenticationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * Class GoogleController
 * Questa classe realizza l'autenticazione tramite oauth2 via Google authentication
 *
 * @package retItalia\AuthenticationBundle\Controller
 */
class GoogleController extends Controller
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/login", name="login")
     */
    public function connectAction()
    {
        // will redirect to Facebook!
        $scope = $this->getParameter('scope_auth');
        if(!isset($scope)){
            $scope = [];
        }

        return $this->get('oauth2.registry')
            ->getClient('google_main') // key used in config.yml
            ->redirect($scope);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function connect() {

        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient $client */
        $client = $this->get('oauth2.registry')
            ->getClient('google_main');

        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\GoogleUser $user */
            $user = $client->fetchUser();

            // do something with all this new power!
            //$user->getFirstName();
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            return $this->redirectToRoute('nonAutorizzato');
        }

    }

    /**
     * After going to Google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/authentication", name="connect_google_check", schemes={"https"})
     */
    public function connectCheckAction(Request $request)
    {
        $this->connect();
    }

    /**
     * After going to Google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/authentication_dev", name="connect_google_check_dev")
     */
    public function connectCheckDevAction(Request $request)
    {
        $this->connect();
    }

    /**
     *
     * @Route("/non-autorizzato", name="nonAutorizzato")
     */
    public function nonAutorizzatoAction(Request $request)
    {
        return $this->render('@retItaliaAuthentication/Default/NonAutorizzato.html.twig');
    }
}