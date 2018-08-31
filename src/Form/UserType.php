<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\IsTrue;
use Doctrine\Common\Collections\ArrayCollection;

class UserType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('username', TextType::class)
        ->add('email', EmailType::class)
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => ['label'=>'Password'],
            'second_options' => ['label'=>'Repita o Password']
        ])
        ->add('fullname', TextType::class, ['label'=>"Nome completo"])
        ->add('termsAgreed', CheckboxType::class, [
            'mapped'=>false,
            'constraints' => new IsTrue(),
            'label' => 'Eu aceito os termos do serviço'
        ]) // Mapped significa que ele não está persistido na classe User
                
        
        
        ->add('Registrar', SubmitType::class);  
    }

    public function configureOptions(OptionsResolver $resolver){
        // Entity
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

  
}
?>