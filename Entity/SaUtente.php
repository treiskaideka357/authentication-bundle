<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * SaUtente
 *
 * @ORM\Table(name="SA_UTENTE")
 * @ORM\Entity
 */
class SaUtente implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="ID_UTENTE", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_UTENTE_ID_UTENTE_seq", allocationSize=1, initialValue=1)
     */
    private $idUtente;

    /**
     * @var string
     *
     * @ORM\Column(name="USERID", type="string", length=20, nullable=false)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=20, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="COGNOME", type="string", length=30, nullable=false)
     */
    private $cognome;

    /**
     * @var string
     *
     * @ORM\Column(name="NOME", type="string", length=30, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=40, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="FAX", type="string", length=30, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="TELEFONO", type="string", length=30, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="SOSPESO", type="string", length=1, nullable=true)
     */
    private $sospeso;

    /**
     * @var string
     *
     * @ORM\Column(name="GOOGLE_ID", type="string", length=200, nullable=true)
     */
    private $googleId;

    /**
     * @var SaUfficio
     *
     * @ORM\ManyToOne(targetEntity="SaUfficio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_UFFICIO", referencedColumnName="ID_UFFICIO")
     * })
     */
    private $idUfficio;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SaAutorizzazione", inversedBy="idUtente")
     * @ORM\JoinTable(name="sa_cor_utente_autorizzazione",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_UTENTE", referencedColumnName="ID_UTENTE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_AUTORIZZAZIONE", referencedColumnName="ID_AUTORIZZAZIONE")
     *   }
     * )
     */
    private $idAutorizzazione;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAutorizzazione = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getUsername()
    {
        return $this->nome;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function getIdUtente()
    {
        return $this->idUtente;
    }

    /**
     * @param string $idUtente
     */
    public function setIdUtente($idUtente)
    {
        $this->idUtente = $idUtente;
    }

    /**
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getSospeso()
    {
        return $this->sospeso;
    }

    /**
     * @param string $sospeso
     */
    public function setSospeso($sospeso)
    {
        $this->sospeso = $sospeso;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    /**
     * @return SaUfficio
     */
    public function getIdUfficio()
    {
        return $this->idUfficio;
    }

    /**
     * @param SaUfficio $idUfficio
     */
    public function setIdUfficio($idUfficio)
    {
        $this->idUfficio = $idUfficio;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdAutorizzazione()
    {
        return $this->idAutorizzazione;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idAutorizzazione
     */
    public function setIdAutorizzazione($idAutorizzazione)
    {
        $this->idAutorizzazione = $idAutorizzazione;
    }

}

