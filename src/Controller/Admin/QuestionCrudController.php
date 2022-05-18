<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Reponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Form\Type\ReponseType;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre_question'),
            TextField::new('aide_question'),
            NumberField::new('note_question'),
            AssociationField::new('reponses'),
/*            AssociationField::new('bonne_reponse'),
            AssociationField::new('module_thematique')*/
        ];
    }
}
