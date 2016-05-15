<?php

namespace BankT\ApiBundle\Form;

use BankT\ApiBundle\Service\BankaccountService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DeviceForm
 * @package BankT\ApiBundle\Form
 */
class DeviceForm extends AbstractType
{
    /**
     * DeviceForm constructor.
     * @param BankaccountService $bankaccountService
     */
    public function __construct(BankaccountService $bankaccountService)
    {
        $this->bankaccountService = $bankaccountService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externalIdentifier')
            ->add('name');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BankT\ApiBundle\Entity\Device',
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
