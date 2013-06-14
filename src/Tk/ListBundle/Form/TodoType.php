<?php

namespace Tk\ListBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tk\UserBundle\Entity\MemberRepository;

class TodoType extends AbstractType
{
    protected $group;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $group = $this->group;
        $builder
            ->add('name')
            ->add('owner', 'entity', array(
                        'class'         => 'TkUserBundle:Member', 
                        'property'      => 'name',
                        'required'      => false,
                        'query_builder' => function(MemberRepository $member) use ($group) {
                            return $member->createQueryBuilder('m')
                                      ->where('m.tgroup = :group')
                                      ->setParameter('group', $group);
                            }
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
