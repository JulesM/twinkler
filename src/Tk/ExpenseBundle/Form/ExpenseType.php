<?php

namespace Tk\ExpenseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('owner', 'entity', array(
                        'class'         => 'TkUserBundle:Member', 
                        'property'      => 'name',
                        ))
                ->add('name', 'text')
                ->add('amount', 'number', array('precision' => 2))
                ->add('date', 'date', array(
                        'input'    => 'datetime',
                        'widget'   => 'choice',
                        ))
                ->add('users', 'entity', array(
                        'class'         => 'TkUserBundle:Member',
                        'property'      => 'name',
                        'multiple'      => 'true',
                        'expanded'      => 'true',
                        'required'      => 'true',
                        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tk\ExpenseBundle\Entity\Expense'
        ));
    }

    public function getName()
    {
        return 'tk_expensebundle_expensetype';
    }
}
