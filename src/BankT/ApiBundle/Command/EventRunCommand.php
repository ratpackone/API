<?php

namespace BankT\ApiBundle\Command;

use BankT\ApiBundle\Entity\Event;
use BankT\ApiBundle\Service\EventService;
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Wrep\Daemonizable\Command\EndlessCommand;

/**
 * Class EventRunCommand
 * @package BankT\ApiBundle\Command
 */
class EventRunCommand extends EndlessCommand implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface|null
     */
    private $container;

    protected function configure()
    {
        $this
            ->setName('event:run')
            ->setDescription('Executes the Events (ENDLESS)');

        $this->setTimeout(1);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        /* @var $eventService EventService */
        $eventService = $container->get('service.event');

        $events = $eventService->findAll();

        foreach ($events as $event) {
            if ($event->getType() == Event::TYPE_INIT) {
                $this->eventInit($event);
            }


            if ($event->getBankaccount()->getDevice()
                && $event->getBankaccount()->getUser()->getNotificationToken()
                && $event->getType() == Event::TYPE_UPDATE
            ) {
                $this->eventUpdate($event);
            }


            $container->get('doctrine')->getManager()->remove($event);
            $container->get('doctrine')->getManager()->flush($event);

        }

        $container->get('doctrine')->getManager()->clear();

        $output->writeln('Command result.'.memory_get_usage(true));
    }

    /**
     * @param Event $event
     */
    public function eventUpdate(Event $event)
    {
        $data = array(
            'device' => $event->getBankaccount()->getDevice()->getExternalIdentifier(),
            'status' => $event->getBankaccount()->getStatus(),
        );

        $message = new AndroidMessage();
        $message->setMessage('BankT updated');
        $message->setData($data);
        $message->setGCM(true);
        $message->setDeviceIdentifier($event->getBankaccount()->getUser()->getNotificationToken());
        $container->get('rms_push_notifications')->send($message);
    }

    /**
     * @param Event $event
     */
    public function eventInit(Event $event)
    {

        $bankaccount = $event->getBankaccount();
        $connection = $bankaccount->getConnection();
        if (empty($connection->getRefreshToken())) {
            return;
        }
        try {
            $token = $container->get('service.figo')->getToken($connection->getRefreshToken());
            $account = $container->get('service.figo')->getAccount(
                $token['access_token'],
                $bankaccount->getExternalIdentifier()
            );

            $bankaccount->setName($account->name);
            $bankaccount->setCurrentAmount($account->balance->balance);
            $container->get('doctrine')->getManager()->flush($bankaccount);
        } catch (\Exception $e) {
        }
    }


    /**
     * @return ContainerInterface
     *
     * @throws \LogicException
     */
    protected function getContainer()
    {
        if (null === $this->container) {
            $application = $this->getApplication();
            if (null === $application) {
                throw new \LogicException(
                    'The container cannot be retrieved as the application instance is not yet set.'
                );
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
