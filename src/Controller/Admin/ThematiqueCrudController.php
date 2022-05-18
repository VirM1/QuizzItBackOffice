<?php

namespace App\Controller\Admin;

use App\Entity\Thematique;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Thematique::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new("id","id")->setPermission(Utilisateur::ROLE_SUPER_ADMIN)->hideOnForm();
        yield TextField::new("libelleThematique","thematique.libelleThematique");
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural("thematique.plural")->setEntityLabelInSingular("thematique.singular");
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE,Utilisateur::ROLE_SUPER_ADMIN);
    }
}
