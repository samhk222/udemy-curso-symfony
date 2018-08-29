<?php

namespace App\Form;

use App\Entity\MicroPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\SubmitType;
use Symfony\Component\Form\Extension\Core\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroPostType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('text', TextareaType::class, ['label'=>false])
                ->add('save', SubmitType::class);  
    }

    public function configureOptions(OptionsResolver $resolver){
        // Entity
        $resolver->setDefaults([
            'data_class' => MicroPost::class
        ]);
    }

  
}
?>