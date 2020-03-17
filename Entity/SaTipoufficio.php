<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaTipoufficio
 *
 * @ORM\Table(name="SA_TIPOUFFICIO")
 * @ORM\Entity
 */
class SaTipoufficio
{
    /**
     * @var string
     *
     * @ORM\Column(name="TP_UFFICIO", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_TIPOUFFICIO_TP_UFFICIO_seq", allocationSize=1, initialValue=1)
     */
    private $tpUfficio;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=30, nullable=false)
     */
    private $descrizione;

    /**
     * @var string
     *
     * @ORM\Column(name="ALIMENTATORE", type="string", length=1, nullable=false)
     */
    private $alimentatore;

    /**
     * @var string
     *
     * @ORM\Column(name="QUALITA", type="string", length=1, nullable=false)
     */
    private $qualita;

    /**
     * @return string
     */
    public function getTpUfficio()
    {
        return $this->tpUfficio;
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
    public function getAlimentatore()
    {
        return $this->alimentatore;
    }

    /**
     * @return string
     */
    public function getQualita()
    {
        return $this->qualita;
    }


}

