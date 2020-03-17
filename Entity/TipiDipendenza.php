<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipiDipendenza
 *
 * @ORM\Table(name="TIPI_DIPENDENZA")
 * @ORM\Entity
 */
class TipiDipendenza
{
    /**
     * @var string
     *
     * @ORM\Column(name="CODICE_DIPENDENZA", type="string", length=5, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="TIPI_DIPENDENZA_CODICE_DIPENDE", allocationSize=1, initialValue=1)
     */
    private $codiceDipendenza;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=30, nullable=false)
     */
    private $descrizione;

    /**
     * @var string
     *
     * @ORM\Column(name="TIPOLOGIA_SGC", type="string", length=3, nullable=false)
     */
    private $tipologiaSgc;

    /**
     * @return string
     */
    public function getCodiceDipendenza()
    {
        return $this->codiceDipendenza;
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
    public function getTipologiaSgc()
    {
        return $this->tipologiaSgc;
    }


}

