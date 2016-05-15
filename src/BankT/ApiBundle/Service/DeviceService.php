<?php

namespace BankT\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class DeviceService
 * @package BankT\ApiBundle\Service
 */
class DeviceService
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * Devices constructor.
     * @param EntityManager $entityManager
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(\BankT\ApiBundle\Entity\Device::class);
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findBy(array('user' => $this->getUser()));
    }

    /**
     * @param string $identifier
     * @return null|object
     */
    public function findByIdentifier($identifier)
    {
        return $this->getRepository()->findOneBy(array('user' => $this->getUser(), 'identifier' => $identifier));
    }
}
