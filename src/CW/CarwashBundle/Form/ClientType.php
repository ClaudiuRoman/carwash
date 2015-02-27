<?php

namespace CW\CarwashBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licencePlate', 'text', [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CW\CarwashBundle\Entity\Client',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'carwash_client';
    }
}
