<?php

namespace BankT\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return array
     */
    public function getAction()
    {
        return array();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function postAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($username);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $this->get('doctrine.orm.entity_manager')->persist($user);

        $userManager->updatePassword($user);
        $userManager->updateCanonicalFields($user);

        $this->get('doctrine.orm.entity_manager')->flush($user);

        $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);

        return array('token' => $token);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function patchAction(Request $request)
    {
        $user = $this->getUser();

        if ($request->request->get('notificationToken')) {
            $user->setNotificationToken($request->request->get('notificationToken'));
            $this->getDoctrine()->getManager()->flush();
            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return View::create(array(), 400);
    }
}
