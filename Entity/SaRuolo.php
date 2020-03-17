<?php

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SaRuolo
 *
 * @ORM\Table(name="SA_RUOLO")
 * @ORM\Entity
 */
class SaRuolo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_RUOLO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SA_RUOLO_ID_RUOLO_seq", allocationSize=1, initialValue=1)
     *
     * @Assert\Type("integer")
     */
    private $idRuolo;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIZIONE", type="string", length=100, nullable=true)
     *
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "La lunghezza massima del campo descrizione è di 100 caratteri"
     * )
     * @Assert\Type("string")
     */
    private $descrizione;

    /**
     * @return int
     */
    public function getIdRuolo()
    {
        return $this->idRuolo;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param int $idRuolo
     */
    public function setIdRuolo($idRuolo)
    {
        $this->idRuolo = $idRuolo;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

}

