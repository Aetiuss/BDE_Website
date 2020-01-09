<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
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
            ]);
    }

    public function configuratioOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            "data_class" => SearchData::class,
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
