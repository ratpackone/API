<?php


namespace BankT\ApiBundle\Service;


use BankT\ApiBundle\Entity\Bankaccount;
use BankT\ApiBundle\Entity\Event;
use Doctrine\ORM\EntityManager;

/**
 * Class EventService
 * @package BankT\ApiBundle\Service
 */
class EventService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Devices constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Bankaccount $bankaccount
     * @param string      $type
     */
    public function add(Bankaccount $bankaccount, $type = Event::TYPE_INIT)
    {
        $event = new Event();
        $event->setBankaccount($bankaccount);
        $event->setType($type);

        $this->entityManager->persist($event);
        $this->entityManager->flush($event);
    }



    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(\BankT\ApiBundle\Entity\Event::class);
    }

    /**
     * @return Event[]
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

}
