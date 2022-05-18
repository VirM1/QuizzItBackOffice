<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

   public function configureFields(string $pageName): iterable
   {
       yield IdField::new("id","id");

       yield EmailField::new("email",'utilisateur.email');

       yield TextField::new("nomUtilisateur","utilisateur.nom");

       yield TextField::new("prenomUtilisateur","utilisateur.prenom");

       yield ChoiceField::new("roles","utilisateur.roles")->setChoices(Utilisateur::AVAILABLE_ROLES);
   }

   public function configureCrud(Crud $crud): Crud
   {
       return $crud
           ->setEntityLabelInSingular("utilisateur.singular")
           ->setEntityLabelInPlural("utilisateur.plural");
   }
}
