<?php

namespace BankT\ApiBundle\Controller;

use BankT\ApiBundle\Entity\Bankaccount;
use BankT\ApiBundle\Entity\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConnectController
 * @package BankT\ApiBundle\Controller
 */
class ConnectController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function cgetAction(Request $request)
    {
        return $this->get('doctrine')->getManager()->getRepository(Connection::class)->findBy(
            array('user' => $this->getUser())
        );
    }

    /**
     * @param string $identifier
     * @return null|object
     */
    public function getAction($identifier)
    {
        if ($identifier == "figo") {
            $url = $this->get('service.figo')->getRedirectUrl();

            return array(
                'service' => 'figo',
                'redirect_url' => $url,
            );
        }

        return View::create('Service not availaibe', 400);
    }

    /**
     * @return Connection
     */
    public function postAction($identifier, Request $request)
    {
        $code = $request->request->get('code');

        $token = $this->get('service.figo')->getToken($code);

        $connection = new Connection();
        $connection->setUser($this->getUser());
        $connection->setToken($token['access_token']);
        $connection->setRefreshToken((isset($token['refresh_token']) ? $token['refresh_token'] : null));
        $connection->setName('figo');

        $this->get('doctrine')->getManager()->persist($connection);
        $this->get('doctrine')->getManager()->flush();

        $accounts = $this->get('service.figo')->getAccounts($connection->getToken());
        $this->get('doctrine')->getManager()->persist($connection);

        foreach ($accounts as $account) {
            $bankaccount = new Bankaccount();
            $bankaccount->setName($account->name.'-'.$account->account_number);
            $bankaccount->setUser($this->getUser());
            $bankaccount->setConnection($connection);
            $bankaccount->setExternalIdentifier($account->account_id);
            $this->get('doctrine')->getManager()->persist($bankaccount);

            $this->get('service.event')->add($bankaccount);
        }

        $this->get('doctrine')->getManager()->flush();

        return $connection;
    }
}
