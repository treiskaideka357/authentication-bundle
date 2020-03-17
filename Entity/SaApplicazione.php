<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaApplicazione
 *
 * @ORM\Table(name="SA_APPLICAZIONE")
 * @ORM\Entity
 */
class SaApplicazione
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_APPLICAZIONE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_APPLICAZIONE_ID_APPLICAZION", allocationSize=1, initialValue=1)
     */
    private $idApplicazione;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=100, nullable=true)
     */
    private $descrizione;

    /**
     * @return int
     */
    public function getIdApplicazione()
    {
        return $this->idApplicazione;
    }

    /**
     * @param int $idApplicazione
     */
    public function setIdApplicazione($idApplicazione)
    {
        $this->idApplicazione = $idApplicazione;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }



}

