<?php

namespace App\Form;

use App\Entity\VisitorEmailResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitorEmailResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('created_at')
            ->add('subject', TextType::class, [
                "label" => "Sujet"
            ])
            ->add('content', TextareaType::class, [
                "label" => "Votre message",
                "attr" => [
                    "placeholder" =>  "Veuillez entrer votre message ..."            
                ]
                
            ])

            ->add('submit', SubmitType::class, [
                "label" => "Envoyer la réponse"
            ])
            
            //->add('visitorMessage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VisitorEmailResponse::class,
        ]);
    }
}
