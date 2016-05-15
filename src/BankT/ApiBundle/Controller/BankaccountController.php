<?php

namespace BankT\ApiBundle\Controller;

use BankT\ApiBundle\Entity\Event;
use BankT\ApiBundle\Form\BankaccountForm;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BankaccountController
 * @package BankT\ApiBundle\Controller
 */
class BankaccountController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @return array
     */
    public function cgetAction()
    {
        return $this->get('service.bankaccount')->findAll();
    }

    /**
     * @param string $identifier
     * @return null|object
     */
    public function getAction($identifier)
    {
        return $this->get('service.bankaccount')->findByIdentifier($identifier);
    }

    /**
     * @param Request $request
     * @param string  $identifier
     * @return View
     */
    public function patchAction(Request $request, $identifier)
    {
        $bankaccount = $this->get('service.bankaccount')->findByIdentifier($identifier);

        $form = $this->get('form.factory')->createNamed(
            '',
            BankaccountForm::class,
            $bankaccount,
            array('method' => 'PUT')
        );

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush($bankaccount);

            $this->get('service.event')->add($bankaccount, Event::TYPE_UPDATE);

            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return View::create($form, 400);
    }
}
