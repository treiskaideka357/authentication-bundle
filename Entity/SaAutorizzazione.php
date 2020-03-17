<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaAutorizzazione
 *
 * @ORM\Table(name="SA_AUTORIZZAZIONE")
 * @ORM\Entity
 */
class SaAutorizzazione
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_AUTORIZZAZIONE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_AUTORIZZAZIONE_ID_AUTORIZZA", allocationSize=1, initialValue=1)
     */
    private $idAutorizzazione;

    /**
     * @var SaApplicazione
     *
     * @ORM\ManyToOne(targetEntity="SaApplicazione")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_APPLICAZIONE", referencedColumnName="ID_APPLICAZIONE")
     * })
     */
    private $idApplicazione;

    /**
     * @var SaRuolo
     *
     * @ORM\ManyToOne(targetEntity="SaRuolo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RUOLO", referencedColumnName="ID_RUOLO")
     * })
     */
    private $idRuolo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SaUtente", mappedBy="idAutorizzazione")
     */
    private $idUtente;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SaFunzione", mappedBy="idAutorizzazione")
     */
    private $idFunzione;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUtente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFunzione = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return SaApplicazione
     */
    public function getIdApplicazione()
    {
        return $this->idApplicazione;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFunzione()
    {
        return $this->idFunzione;
    }

    /**
     * @return int
     */
    public function getIdAutorizzazione()
    {
        return $this->idAutorizzazione;
    }

    /**
     * @return SaRuolo
     */
    public function getIdRuolo()
    {
        return $this->idRuolo;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdUtente()
    {
        return $this->idUtente;
    }

}

