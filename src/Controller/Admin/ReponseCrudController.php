<?php

namespace App\Controller\Admin;

use App\Admin\Filter\RelationFilter;
use App\Entity\ModuleThematique;
use App\Entity\Reponse;
use App\Entity\Thematique;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reponse::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new("id","id")->setPermission(Utilisateur::ROLE_SUPER_ADMIN);

        yield TextField::new('titreReponse',"reponse.titre");

        yield AssociationField::new('question',"shared.question");

    }
     public function configureCrud(Crud $crud): Crud
     {
         return $crud->setEntityLabelInPlural("reponse.plural")
             ->setEntityLabelInSingular("reponse.singular");
     }

     public function configureFilters(Filters $filters): Filters
     {
         return $filters
             ->add("question")
             ->add(
                 RelationFilter::new(
                     "question.moduleThematique",
                     "libelleModuleThematique",
                     Thematique::class,
                     "shared.module")
             )
             ;
     }
}
