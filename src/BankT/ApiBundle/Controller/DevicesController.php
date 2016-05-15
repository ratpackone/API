<?php

namespace BankT\ApiBundle\Controller;

use BankT\ApiBundle\Entity\Device;
use BankT\ApiBundle\Form\DeviceForm;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DevicesController
 * @package BankT\ApiBundle\Controller
 */
class DevicesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return array
     */
    public function cgetAction()
    {
        return $this->get('service.device')->findAll();
    }

    /**
     * @param $identifier
     * @return null|object
     */
    public function getAction($identifier)
    {
        return $this->get('service.device')->findByIdentifier($identifier);
    }

    /**
     * @param Request $request
     * @return Device|\Symfony\Component\Form\Form
     */
    public function postAction(Request $request)
    {
        $device = new Device();
        $device->setUser($this->getUser());

        $form = $this->get('form.factory')->createNamed('', DeviceForm::class, $device);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($device);
            $em->flush();

            return View::createRouteRedirect('get_devices', ['identifier' => $device->getIdentifier()], 201);
        }

        return View::create($form, 400);
    }

}
