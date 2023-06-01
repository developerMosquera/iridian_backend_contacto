<?php

namespace App\Form;

use App\Entity\AreaContacto;
use App\Entity\Contacto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('apellido', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('correo', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('celular', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('mensaje', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('areaContacto', EntityType::class, [
                'class' => AreaContacto::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Enviar', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top: 15px;']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacto::class,
        ]);
    }
}
