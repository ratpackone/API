<?php


namespace BankT\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSA;

/**
 * @ORM\Entity
 * @ORM\Table
 * @JMSA\ExclusionPolicy("all")
 */
class Event
{

    /**
     * @const
     */
    const TYPE_UPDATE = 'update';

    /**
     * @const
     */
    const TYPE_INIT = 'init';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Bankaccount
     *
     * @ORM\ManyToOne(targetEntity="Bankaccount")
     * @ORM\JoinColumn(name="bankaccount_id", referencedColumnName="id")
     */
    protected $bankaccount;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Bankaccount
     */
    public function getBankaccount()
    {
        return $this->bankaccount;
    }

    /**
     * @param Bankaccount $bankaccount
     */
    public function setBankaccount($bankaccount)
    {
        $this->bankaccount = $bankaccount;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}
