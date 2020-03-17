<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 18/12/18
 * Time: 16.33
 */

namespace retItalia\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntranetLogApp
 *
 * @ORM\Table(name="INTRANET_LOG_APP")
 * @ORM\Entity
 */
class IntranetLogApp
{

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_LOG", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="S_INTRANET_LOG", allocationSize=1, initialValue=1)
     */
    private $idLog;

    /**
     * @var SaUtente
     *
     * @ORM\ManyToOne(targetEntity="SaUtente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_UTENTE", referencedColumnName="ID_UTENTE")
     * })
     */
    private $idUtente;

    /**
     * @var SaFunzione
     *
     * @ORM\ManyToOne(targetEntity="SaFunzione")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FUNZIONE", referencedColumnName="ID_FUNZIONE")
     * })
     */
    private $idFunzione;

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
     * @var string
     *
     * @ORM\Column(name="DETTAGLI", type="string", length=100, nullable=true)
     */
    private $dettagli;

    /**
     * @var string
     *
     * @ORM\Column(name="ID_OBJECT", type="string", length=20, nullable=true)
     */
    private $idObject;

    /**
     * @var string
     *
     * @ORM\Column(name="OBJ_JSON", type="string", nullable=true)
     */
    private $objJson;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATA_LOG", type="datetime", nullable=false)
     */
    private $dataLog;

    /**
     * @return int
     */
    public function getIdLog()
    {
        return $this->idLog;
    }

    /**
     * @param int $idLog
     */
    public function setIdLog($idLog)
    {
        $this->idLog = $idLog;
    }

    /**
     * @return SaUtente
     */
    public function getIdUtente()
    {
        return $this->idUtente;
    }

    /**
     * @param SaUtente $idUtente
     */
    public function setIdUtente($idUtente)
    {
        $this->idUtente = $idUtente;
    }

    /**
     * @return SaFunzione
     */
    public function getIdFunzione()
    {
        return $this->idFunzione;
    }

    /**
     * @param SaFunzione $idFunzione
     */
    public function setIdFunzione($idFunzione)
    {
        $this->idFunzione = $idFunzione;
    }

    /**
     * @return SaApplicazione
     */
    public function getIdApplicazione()
    {
        return $this->idApplicazione;
    }

    /**
     * @param SaApplicazione $idApplicazione
     */
    public function setIdApplicazione($idApplicazione)
    {
        $this->idApplicazione = $idApplicazione;
    }

    /**
     * @return string
     */
    public function getDettagli()
    {
        return $this->dettagli;
    }

    /**
     * @param string $dettagli
     */
    public function setDettagli($dettagli)
    {
        $this->dettagli = $dettagli;
    }

    /**
     * @return string
     */
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * @param string $idObject
     */
    public function setIdObject($idObject)
    {
        $this->idObject = $idObject;
    }

    /**
     * @return string
     */
    public function getObjJson()
    {
        return $this->objJson;
    }

    /**
     * @param string $objJson
     */
    public function setObjJson($objJson)
    {
        $this->objJson = $objJson;
    }

    /**
     * @return \DateTime
     */
    public function getDataLog()
    {
        return $this->dataLog;
    }

    /**
     * @param \DateTime $dataLog
     */
    public function setDataLog($dataLog)
    {
        $this->dataLog = $dataLog;
    }

}