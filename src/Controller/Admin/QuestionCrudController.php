<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Form\Type\ReponseType;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new("id","id")->setPermission(Utilisateur::ROLE_SUPER_ADMIN);
        yield TextField::new('titreQuestion',"question.titre");
        yield TextField::new('aideQuestion',"question.aide");
        yield NumberField::new('noteQuestion',"question.note");
        yield AssociationField::new("moduleThematique","question.module");
        yield AssociationField::new("bonneReponse","question.bonneReponse")->hideWhenCreating();
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInSingular("question.singular")->setEntityLabelInPlural("question.plural");
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new("moduleThematique","question.module"));
    }
}
