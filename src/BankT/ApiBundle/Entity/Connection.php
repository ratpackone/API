<?php

namespace BankT\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSA;

/**
 * @ORM\Entity
 * @ORM\Table
 * @JMSA\ExclusionPolicy("all")
 */
class Connection
{

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
     * @var Bankaccount
     *
     * @ORM\OneToMany(targetEntity="Bankaccount", mappedBy="connection")
     * @JMSA\Expose
     */
    protected $bankaccounts;

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
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $refreshToken;

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
     * @return Bankaccount
     */
    public function getBankaccounts()
    {
        return $this->bankaccounts;
    }

    /**
     * @param Bankaccount $bankaccounts
     */
    public function setBankaccounts($bankaccounts)
    {
        $this->bankaccounts = $bankaccounts;
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
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

}
