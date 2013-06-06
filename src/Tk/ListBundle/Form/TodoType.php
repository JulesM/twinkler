<?php

namespace Tk\ListBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('owner', 'entity', array(
                        'class'         => 'TkUserBundle:User', 
                        'property'      => 'username',
                        'required'      => false,
                        ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tk\ListBundle\Entity\Todo'
        ));
    }

    public function getName()
    {
        return 'tk_listbundle_todotype';
    }
}
