<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre'
            ])
            ->add('decription')
            ->add('surface')
            ->add('rooms', null , [
                'label' => 'Pieces'
            ])
            ->add('bedrooms', null , [
                'label' => 'Chambres'
            ])
            ->add('floor',null, [
                'label' => 'Étages'
            ])
            ->add('price', null , [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class , [
                'label' => 'Chauffage',
                'choices' => $this->getChoices()
            ])
            ->add('city', null , [
                'label' => 'Ville'
            ])
            ->add('adress', null , [
                'label' => 'Address'
            ])
            ->add('sold', null , [
                'label' => 'Vendu'
            ])
            ->add('postal_code', null , [
                'label' => 'Code Postal'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    public function getChoices()
    {
        $output = [];
        foreach(Property::HEAT as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
