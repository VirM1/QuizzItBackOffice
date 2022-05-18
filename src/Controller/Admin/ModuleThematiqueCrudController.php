<?php

namespace App\Controller\Admin;

use App\Entity\ModuleThematique;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ModuleThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ModuleThematique::class;
    }

    public function configureFields(string $pageName): iterable
    {
            yield TextField::new('libelleModuleThematique',"moduleThematique.libelle");
            yield AssociationField::new('thematique',"shared.thematique");
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural("moduleThematique.plural")->setEntityLabelInSingular("moduleThematique.singular");
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE,Utilisateur::ROLE_SUPER_ADMIN);
    }
}
