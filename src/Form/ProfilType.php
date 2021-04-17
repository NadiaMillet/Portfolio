<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;




class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', CKEditorType::class)
            ->add(
                'img',
                FileType::class,
                array('data_class' => null),
                ['label' => 'Ajouter une photo de profil']
            )
            ->add(
                'cv',
                FileType::class,
                array('data_class' => null),
                ['label' => 'Ajouter un CV']
            )
            ->add(
                'Enregistrer',
                SubmitType::class,
                [
                    'attr' => ['class' => 'save'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
