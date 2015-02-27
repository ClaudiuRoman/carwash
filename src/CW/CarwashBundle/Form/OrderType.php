<?php

namespace CW\CarwashBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', new ClientType(), [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('products', 'entity', [
                'class' => 'CW\CarwashBundle\Entity\Product',
                'property' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
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
            'data_class' => 'CW\CarwashBundle\Entity\Order',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'carwash_order';
    }

}
