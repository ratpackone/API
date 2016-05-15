<?php

namespace BankT\ApiBundle\Service;

use BankT\ApiBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserService
 * @package BankT\ApiBundle\Service
 */
class UserService
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
     * @param TokenStorage  $tokenStorage
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
        return $this->entityManager->getRepository(User::class);
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
        return $this->getRepository()->findBy(array('fkUser' => $this->getUser()));
    }

}
