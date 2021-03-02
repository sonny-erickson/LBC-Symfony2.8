<?php


namespace QuizzBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

/**
 * Class RegistrationFormType
 * @package QuizzBundle\Form
 */
class RegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville');
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }

}