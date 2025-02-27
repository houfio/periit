<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Material;
use App\Entity\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('search', TextType::class, ['required' => false])
            ->add('order_by', HiddenType::class)
            ->add('order_as', HiddenType::class)
            ->add('levels', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('materials', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('methods', EntityType::class, [
                'class' => Method::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('filter', SubmitType::class);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
