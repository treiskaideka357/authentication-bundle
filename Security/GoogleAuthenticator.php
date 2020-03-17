<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/03/18
 * Time: 12.00
 */

namespace retItalia\AuthenticationBundle\Security;

use League\OAuth2\Client\Provider\GoogleUser;
use retItalia\AuthenticationBundle\Entity\SaAutorizzazione;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use League\OAuth2\Client\Provider\Google;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Doctrine\ORM\EntityManager;

class GoogleAuthenticator extends SocialAuthenticator
{

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * Default message for authentication failure.
     *
     * @var string
     */
    private $failMessage = 'Invalid credentials';

    /**
     * @var ClientRegistry
     */
    private $clientRegistry;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Questa variabile contiene l'application id
     *
     * @var string
     */
    private $applicationId;

    /**
     * Creates a new instance of FormAuthenticator
     *
     * GoogleAuthenticator constructor.
     * @param ClientRegistry $clientRegistry
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param $applicationId
     */
    public function __construct(ClientRegistry $clientRegistry, EntityManager $em, RouterInterface $router, $applicationId) {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
        $this->applicationId=$applicationId;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return ( ($request->attributes->get('_route') === 'connect_google_check') || ($request->attributes->get('_route') === 'connect_google_check_dev') );
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true

        // For Symfony lower than 3.4 the supports method need to be called manually here:
        // if (!$this->supports($request)) {
        //     return null;
        // }

        $accessToken=$this->fetchAccessToken($this->getGoogleClient());
        $session = $request->getSession();
        $session->set('googleTokenF',$accessToken);

        //return null;

        return $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        //Setto la variabile autorizzato a false
        $autorizzato=false;

        // 1) have they logged in with Google before? Easy!
        $user = $this->em->getRepository('retItaliaAuthenticationBundle:SaUtente')
            ->findOneBy(['googleId' => $googleUser->getId(),'sospeso'=>['0',null]]);

        if ($user) {

            //Controllo se l'utente ha un'autorizzazione per l'applicazione
            if ($this->controllaAutorizzazione($user))
                return $user;
        }

        // 2) do we have a matching user by email?
        $user = $this->em->getRepository('retItaliaAuthenticationBundle:SaUtente')
            ->findOneBy(['email' => $email,'sospeso'=>['0',null]]);

        //Controllo se l'utente ha un'autorizzazione per l'applicazione
        if (!$this->controllaAutorizzazione($user))
            $user=null;

        // 3) Maybe you just want to "register" them by creating
        // a User object
        if (!empty($user)) {
            $user->setGoogleId($googleUser->getId());
            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    /**
     * @return GoogleClient
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry
            // "google_main" is the key used in config.yml
            ->getClient('google_main');
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        /*if ($user->getPassword() === $credentials['password']) {
            return true;
        }*/
        //return true;
        if (empty($user->getIdUtente()))
            throw new CustomUserMessageAuthenticationException($this->failMessage);
        else return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $session = $request->getSession();

        // on success, let the request continue
        $key = '_security.main.target_path'; #where "main" is your firewall name

        //check if the referrer session key has been set
        if ($session->has($key)) {
            //set the url based on the link they were trying to access before being authenticated
            $url = $session->get($key);

            //remove the session key
            $session->remove($key);
        }
        //if the referrer key was never set, redirect to a default route
        else{
            $url = $this->router->generate('homepage');
        }

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('nonAutorizzato');
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('login');
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * Questa funzione verifica se l'utente è autorizzato per uno specifico application id
     *
     * @param $user
     * @return bool
     */
    private function controllaAutorizzazione($user) {

        //Preimposto autorizzato a false
        $autorizzato=false;

        //Innanzitutto controllo se l'entity utente non è vuota
        if (!empty($user)) {

            //Controllo se l'utente ha un'autorizzazione per l'applicazione
            $autorizzazioni=$user->getIdAutorizzazione();

            foreach($autorizzazioni as $autorizzazione){
                /** @var SaAutorizzazione $autorizzazione */
                if ($autorizzazione->getIdApplicazione()->getIdApplicazione()==$this->applicationId) {
                    $autorizzato=true;
                    break;
                }

            }

        }



        return $autorizzato;
    }
}