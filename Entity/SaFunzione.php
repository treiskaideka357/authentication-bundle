<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaFunzione
 *
 * @ORM\Table(name="SA_FUNZIONE")
 * @ORM\Entity
 */
class SaFunzione
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_FUNZIONE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_FUNZIONE_ID_FUNZIONE_seq", allocationSize=1, initialValue=1)
     */
    private $idFunzione;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=100, nullable=true)
     */
    private $descrizione;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SaAutorizzazione", inversedBy="idFunzione")
     * @ORM\JoinTable(name="sa_corr_ruolo_funzione",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_FUNZIONE", referencedColumnName="ID_FUNZIONE")
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

    /**
     * @return int
     */
    public function getIdFunzione()
    {
        return $this->idFunzione;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdAutorizzazione()
    {
        return $this->idAutorizzazione;
    }


}

