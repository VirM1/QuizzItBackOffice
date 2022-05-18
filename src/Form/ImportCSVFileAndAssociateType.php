<?php

namespace App\Form;

use App\Entity\ModuleThematique;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportCSVFileAndAssociateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileImport',FileType::class,array(
                "constraints"=>array(new File(array(
                    "mimeTypes"=>array("application/vnd.ms-excel","text/csv","application/vnd.oasis.opendocument.spreadsheet"),
                    "maxSize"=>"3M"
                ))),
                "label"=>"import.fileImport"
            ))
            ->add("module",EntityType::class,array(
                'class' => ModuleThematique::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.libelleModuleThematique', 'ASC');
                },
                'choice_label' => 'libelleModuleThematique',
                "attr"=>array("class"=>"form-select"),
                "label"=>"import.module"
            ))
            ->add("submit",SubmitType::class,array("attr"=>array("class"=>"btn btn-primary"),"label"=>"import.validate"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
