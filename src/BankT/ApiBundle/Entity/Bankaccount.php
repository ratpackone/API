<?php

namespace BankT\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSA;

/**
 * @ORM\Entity
 * @ORM\Table
 * @JMSA\ExclusionPolicy("all")
 */
class Bankaccount
{
    const STATUS_OK = "OK";
    const STATUS_WARNING = "WARNING";
    const STATUS_ALARM = "ALARM";

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Device
     *
     * @ORM\ManyToOne(targetEntity="Device")
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id", nullable=true)
     * @JMSA\Expose
     */
    protected $device;

    /**
     * @var Connection
     *
     * @ORM\ManyToOne(targetEntity="Connection", inversedBy="bankaccounts")
     * @ORM\JoinColumn(name="connection_id", referencedColumnName="id")
     */
    protected $connection;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @JMSA\Expose
     */
    protected $identifier;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @JMSA\Expose
     */
    protected $externalIdentifier;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @JMSA\Expose
     */
    protected $amountWarning = 500;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @JMSA\Expose
     */
    protected $amountAlarm = 100;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @JMSA\Expose
     */
    protected $currentAmount;

    /**
     * @var int
     * @ORM\Column(type="string")
     * @JMSA\Expose
     */
    protected $name;

    /**
     * @var string
     * @JMSA\Expose
     * @JMSA\Accessor(getter="getStatus")
     */
    protected $status;

    public function __construct()
    {
        $this->identifier = bin2hex(random_bytes(28));
    }

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getAmountWarning()
    {
        return $this->amountWarning;
    }

    /**
     * @param int $amountWarning
     */
    public function setAmountWarning($amountWarning)
    {
        $this->amountWarning = $amountWarning;
    }

    /**
     * @return int
     */
    public function getAmountAlarm()
    {
        return $this->amountAlarm;
    }

    /**
     * @param int $amountAlarm
     */
    public function setAmountAlarm($amountAlarm)
    {
        $this->amountAlarm = $amountAlarm;
    }

    /**
     * @return int
     */
    public function getCurrentAmount()
    {
        return $this->currentAmount;
    }

    /**
     * @param int $currentAmount
     */
    public function setCurrentAmount($currentAmount)
    {
        $this->currentAmount = $currentAmount;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getExternalIdentifier()
    {
        return $this->externalIdentifier;
    }

    /**
     * @param string $externalIdentifier
     */
    public function setExternalIdentifier($externalIdentifier)
    {
        $this->externalIdentifier = $externalIdentifier;
    }

    /**
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        if ($this->getCurrentAmount() <= $this->getAmountAlarm()) {
            return self::STATUS_ALARM;
        } else if ($this->getCurrentAmount() <= $this->getAmountWarning()) {
            return self::STATUS_WARNING;
        }

        return self::STATUS_OK;
    }

    /**
     * @return Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param Device $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }


}
