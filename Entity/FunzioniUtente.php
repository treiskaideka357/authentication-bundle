<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\EntityManager;

class FunzioniUtente
{

    /**
     * Questa proprietà contiene il servizio di gestione token di login, passato tramite DI
     */
    private $tokenStorage;

    /**
     * Questa proprietà contiene l'identificativo dell'applicativo
     */
    private $application_id;

    /**
     * Questa proprietà contiene l'entity manager
     */
    private $em;

    /**
     * Questa proprietà contiene il servizio di controllo se l'utente è loggato
     */
    private $authorizationChecker;

    /**
     * FunzioniUtente constructor.
     * @param $tokenStorage
     * @param $application_id
     * @param $em
     * @throws \Exception
     */
    public function __construct($tokenStorage, $application_id, EntityManager $em, $authorizationChecker)
    {
        //Imposto i valori che mi vengono passati tramite Constructor Injection
        $this->tokenStorage = $tokenStorage;

        //Associo l'etnity manager
        $this->em=$em;

        //Inanzitutto mi testo che $idRamo non sia nullo, altrimenti sollevo un'eccezione
        if (empty($application_id))
            throw new \Exception("Nel file di configurazione non è stato impostato il parametro application_id");

        $app = null;
        try {
            $app = $em->getRepository(SaApplicazione::class,"bdc")->find($application_id);
        }
        catch (\Exception $e) {
            $test = $em->getRepository(SaApplicazione::class,"bdc")->findAll();
            if (empty($test)){
                throw new \Exception("Errore di connessione alla base dati");
            }else{
                throw new \Exception("Errore nella configurazione dell'applicazione (application_id)");
            }
        }

        if (empty($app)){
            throw new \Exception("Il parametro application_id non è valido");
        }

        $this->application_id = $application_id;

        $this->authorizationChecker=$authorizationChecker;

    }

    /**
     * Questa funzione verifica se l'utente loggato è autorizzato all'accesso per l'applicazione
     *
     * @return bool
     */
    public function isApplicationAuthorized(){

        $application = [];

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $autorizzazioni = $this->tokenStorage->getToken()->getUser()->getIdAutorizzazione();

            foreach($autorizzazioni as $autorizzazione){
                $application[] = $autorizzazione->getIdApplicazione()->getIdApplicazione();
            }

        }


        return in_array($this->application_id, $application);
    }

    /**
     * Questa funzione verifica se l'utente loggato è autorizzato all'accesso per una specifica funzione
     *
     * @param $function
     * @return bool
     */
    public function isFunctionAuthorized($function){

        $functions = [];

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $autorizzazioni = $this->tokenStorage->getToken()->getUser()->getIdAutorizzazione();

            foreach($autorizzazioni as $autorizzazione){
                foreach($autorizzazione->getIdFunzione() as $value){
                    $functions[] = $value->getIdFunzione();
                }
            }

        }

        return in_array($function, $functions);
    }

    /**
     * Questa funzione verifica se l'utente loggato è legato al ruolo passato in input
     *
     * @param $idRole
     * @return bool
     */
    public function hasRole($idRole){

        //Inizializzo l'array dei ruoli
        $roles = [];

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $autorizzazioni = $this->tokenStorage->getToken()->getUser()->getIdAutorizzazione();

            // Ciclo tutte le autorizzazioni per estrarre i ruoli
            foreach($autorizzazioni as $autorizzazione){
                if($autorizzazione->getIdApplicazione()->getIdApplicazione() == $this->application_id){

                    /** @var SaAutorizzazione $autorizzazione */

                    //Estraggo il singolo ruolo
                    $ruolo=$autorizzazione->getIdRuolo();

                    //Aggiungo il ruolo all'array
                    $roles[] = $ruolo->getIdRuolo();
                }
            }
        }

        //Restituisco un booleano positivo se l'array contiene il ruolo passato in input, altrimenti restituisco false
        return in_array($idRole, $roles);
    }

    /**
     * Questa funzione inserisce una nuova occorrenza nel file di log
     *
     * @param string $idObject
     * @param string $objJson
     * @param string $idFunzione
     * @param string $dettagli
     * @throws \Exception
     */
    public function insertLog($idObject="",$objJson="",$idFunzione="",$dettagli=""){

        //Creo una nuova istanza di log
        $intranetLogApp = new IntranetLogApp();

        $intranetLogApp->setDettagli($dettagli);
        if (!empty($idFunzione)) {
            $repository = $this->em->getRepository('retItaliaAuthenticationBundle:SaFunzione');
            $saFunzione=$repository->find($idFunzione);
            if (!empty($saFunzione)) {
                $intranetLogApp->setIdFunzione($saFunzione);
            }
        }
        $intranetLogApp->setIdObject($idObject);
        $intranetLogApp->setObjJson($objJson);

        if (!empty($this->application_id)) {
            $repository = $this->em->getRepository('retItaliaAuthenticationBundle:SaApplicazione');
            $saApplicazione=$repository->find($this->application_id);
            if (!empty($saApplicazione)) {
                $intranetLogApp->setIdApplicazione($saApplicazione);
            }
        }
        $intranetLogApp->setIdUtente($this->tokenStorage->getToken()->getUser());
        $intranetLogApp->setDataLog(new \DateTime());

        //Persisto l'oggetto
        $this->em->persist($intranetLogApp);

        //Flush di tutto
        $this->em->flush();
    }
}