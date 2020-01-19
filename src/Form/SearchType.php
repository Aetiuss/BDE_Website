<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('q', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Rechercher"
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('min', DateType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Date min'
                ]
            ])
            ->add('max', DateType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Date min'
                ]
            ]);
    }

    public function configurationOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            "data_class" => SearchData::class,
            "method" => "get",
            "csrf_protection" => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
