<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, ['label' => 'Nom complet', 'constraints' => [new NotBlank(['message' => 'Veuillez renseigner votre nom.',]), new Length(['min' => 2, 'max' => 150, 'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.', 'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',]),], 'attr' => ['placeholder' => 'Votre nom complet',],])->add('email', EmailType::class, ['label' => 'Adresse e-mail', 'constraints' => [new NotBlank(['message' => 'Veuillez renseigner votre adresse e-mail.',]), new Email(['message' => 'Veuillez renseigner une adresse e-mail valide.',]), new Length(['max' => 180, 'maxMessage' => 'L’adresse e-mail ne peut pas dépasser {{ limit }} caractères.',]),], 'attr' => ['placeholder' => 'exemple@email.com',],])->add('subject', TextType::class, ['label' => 'Sujet', 'constraints' => [new NotBlank(['message' => 'Veuillez renseigner le sujet.',]), new Length(['min' => 3, 'max' => 255, 'minMessage' => 'Le sujet doit contenir au moins {{ limit }} caractères.', 'maxMessage' => 'Le sujet ne peut pas dépasser {{ limit }} caractères.',]),], 'attr' => ['placeholder' => 'Objet de votre message',],])->add('message', TextareaType::class, ['label' => 'Message', 'constraints' => [new NotBlank(['message' => 'Veuillez renseigner votre message.',]), new Length(['min' => 10, 'max' => 5000, 'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères.', 'maxMessage' => 'Le message ne peut pas dépasser {{ limit }} caractères.',]),], 'attr' => ['placeholder' => 'Écrivez votre message...', 'rows' => 6,],]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ContactMessage::class, 'csrf_protection' => true, 'csrf_field_name' => '_token', 'csrf_token_id' => 'contact_message',]);
    }
}
