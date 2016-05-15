<?php


namespace BankT\ApiBundle\Service;

/**
 * Class FigoService
 * @package BankT\ApiBundle\Service
 */
class FigoService
{

    /**
     * @var \figo\Connection
     */
    protected $connection;

    /**
     * @var \figo\Session
     */
    protected $session;

    /**
     * FigoService constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $callbackUrl
     */
    public function __construct($clientId, $clientSecret, $callbackUrl)
    {
        $this->connection = new \figo\Connection($clientId, $clientSecret, $callbackUrl);
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->connection->login_url("qweqwe", "accounts=ro balance=ro transactions=ro offline");
    }

    /**
     * @param string $code
     * @return array
     * @throws \figo\Exception
     */
    public function getToken($code)
    {
        return $this->connection->obtain_access_token($code);
    }

    /**
     * @return \figo\Session
     */
    public function getSession($token)
    {
        return new \figo\Session($token);
    }

    /**
     * @param string $token
     * @return array
     */
    public function getAccounts($token)
    {
        return $this->getSession($token)->get_accounts();
    }

    /**
     * @param string $token
     * @param string $identifier
     * @return array
     */
    public function getAccount($token, $identifier)
    {
        return $this->getSession($token)->get_account($identifier);
    }

    /**
     * @param string $token
     * @return array
     */
    public function getAccountBalance($token, $accountId)
    {
        return $this->getSession($token)->get_account_balance($accountId);
    }


}
