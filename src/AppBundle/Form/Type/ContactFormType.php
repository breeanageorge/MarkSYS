<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', ChoiceType::class, [
                'choices'           => [
                    'GENERAL INQUIRY' => 'general_inquiry',
                    'SUPPORT REQUEST' => 'support_request',
                    'QUOTE REQUEST'   => 'quote_request',
                ],
                'placeholder'       => '=== select ===',
                'label' => 'Reason for Contact'
            ])
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class);
    }

    public function getBlockPrefix()
    {
        return 'ms_contact_us';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Contact',
            ]
        );
    }
}