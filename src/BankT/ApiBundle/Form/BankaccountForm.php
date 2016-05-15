<?php

namespace BankT\ApiBundle\Form;

use BankT\ApiBundle\Entity\Device;
use BankT\ApiBundle\Service\DeviceService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BankaccountForm
 * @package BankT\ApiBundle\Form
 */
class BankaccountForm extends AbstractType
{
    /**
     * BankaccountForm constructor.
     * @param DeviceService $deviceService
     */
    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amountAlarm')
            ->add('amountWarning')
            ->add(
                'device',
                EntityType::class,
                array(
                    'choices' => $this->deviceService->findAll(),
                    'choice_value' => 'identifier',
                    'class' => Device::class,

                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BankT\ApiBundle\Entity\Bankaccount',
                'csrf_protection' => false,
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
