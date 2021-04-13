<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Technology;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('team')
            ->add('client')
            ->add('description')
            ->add('logoClientFile', VichFileType::class,[
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('firstPictureFile', VichFileType::class,[
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('link')
            ->add('technologies', EntityType::class, [
                'class' => Technology::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('showProject', ChoiceType::class, [
                'choices' => [
                    'oui' => true,
                    'non' => false,
                ]
            ])
            ->add('period',  DateType::class, [
                'widget' => 'choice',
            ])
            ->add('periodEnd',  DateType::class, [
                'widget' => 'choice',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
