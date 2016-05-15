<?php

namespace BankT\ApiBundle\Service;

use BankT\ApiBundle\Entity\Bankaccount;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class BankaccountService
 * @package BankT\ApiBundle\Service
 */
class BankaccountService
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
        return $this->entityManager->getRepository(Bankaccount::class);
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
