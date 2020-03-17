<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaUfficio
 *
 * @ORM\Table(name="SA_UFFICIO", indexes={@ORM\Index(name="IDX_D801ADF88166E0B3", columns={"TP_UFFICIO"}), @ORM\Index(name="IDX_D801ADF8221BBED3", columns={"CODICE_DIPENDENZA"})})
 * @ORM\Entity
 */
class SaUfficio
{
    /**
     * @var string
     *
     * @ORM\Column(name="ID_UFFICIO", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_UFFICIO_ID_UFFICIO_seq", allocationSize=1, initialValue=1)
     */
    private $idUfficio;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=130, nullable=false)
     */
    private $descrizione;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=90, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="WEB", type="string", length=120, nullable=true)
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="QUALITA", type="string", length=1, nullable=true)
     */
    private $qualita;

    /**
     * @var string
     *
     * @ORM\Column(name="CANCELLA", type="string", length=1, nullable=false)
     */
    private $cancella;

    /**
     * @var string
     *
     * @ORM\Column(name="CODICE_CITTA", type="string", length=4, nullable=true)
     */
    private $codiceCitta;

    /**
     * @var string
     *
     * @ORM\Column(name="INDIRIZZO", type="string", length=500, nullable=true)
     */
    private $indirizzo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATA_DISABILITAZIONE", type="date", nullable=true)
     */
    private $dataDisabilitazione;

    /**
     * @var string
     *
     * @ORM\Column(name="ALIMENTATORE", type="string", length=1, nullable=true)
     */
    private $alimentatore;

    /**
     * @var integer
     *
     * @ORM\Column(name="PERIODO_VALIDITA", type="integer", nullable=true)
     */
    private $periodoValidita;

    /**
     * @var string
     *
     * @ORM\Column(name="TELEFONO", type="string", length=100, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="FAX", type="string", length=50, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="ALIMENTATORE_OPP", type="string", length=1, nullable=true)
     */
    private $alimentatoreOpp;

    /**
     * @var SaTipoufficio
     *
     * @ORM\ManyToOne(targetEntity="SaTipoufficio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TP_UFFICIO", referencedColumnName="TP_UFFICIO")
     * })
     */
    private $tpUfficio;

    /**
     * @var TipiDipendenza
     *
     * @ORM\ManyToOne(targetEntity="TipiDipendenza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CODICE_DIPENDENZA", referencedColumnName="CODICE_DIPENDENZA")
     * })
     */
    private $codiceDipendenza;

    /**
     * @return string
     */
    public function getIdUfficio()
    {
        return $this->idUfficio;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @return string
     */
    public function getQualita()
    {
        return $this->qualita;
    }

    /**
     * @return string
     */
    public function getCancella()
    {
        return $this->cancella;
    }

    /**
     * @return string
     */
    public function getCodiceCitta()
    {
        return $this->codiceCitta;
    }

    /**
     * @return string
     */
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    /**
     * @return \DateTime
     */
    public function getDataDisabilitazione()
    {
        return $this->dataDisabilitazione;
    }

    /**
     * @return string
     */
    public function getAlimentatore()
    {
        return $this->alimentatore;
    }

    /**
     * @return int
     */
    public function getPeriodoValidita()
    {
        return $this->periodoValidita;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @return string
     */
    public function getAlimentatoreOpp()
    {
        return $this->alimentatoreOpp;
    }

    /**
     * @return SaTipoufficio
     */
    public function getTpUfficio()
    {
        return $this->tpUfficio;
    }

    /**
     * @return TipiDipendenza
     */
    public function getCodiceDipendenza()
    {
        return $this->codiceDipendenza;
    }


}

