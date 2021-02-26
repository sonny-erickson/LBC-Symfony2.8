<?php


namespace QuizzBundle\Form;

use QuizzBundle\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFindType extends  AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class,[
                'label'=>false,
                'required'=>false,
            ])
            ->add('categorie', EntityType::class,[
                'required'=>false,
                'multiple' => false,
                'class'=>Categories::class
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Rechercher',
                'attr'=>[
                    'class'=>'waves-effect deep-orange waves-light btn-small'
                ]
            ])
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }
}