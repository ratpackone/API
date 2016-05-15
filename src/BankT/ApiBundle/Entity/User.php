<?php

namespace BankT\ApiBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSA;

/**
 * @ORM\Entity
 * @ORM\Table
 * @JMSA\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @JMSA\Expose
     */
    protected $notificationToken;

    /**
     * @return string
     */
    public function getNotificationToken()
    {
        return $this->notificationToken;
    }

    /**
     * @param string $notificationToken
     */
    public function setNotificationToken($notificationToken)
    {
        $this->notificationToken = $notificationToken;
    }
}
