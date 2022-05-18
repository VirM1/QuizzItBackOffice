<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Utilisateur;
use App\Form\ReponseType;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new("id", "id")->setPermission(Utilisateur::ROLE_SUPER_ADMIN)->hideOnForm();
        yield TextField::new('titreQuestion', "question.titre");
        yield TextField::new('aideQuestion', "question.aide");
        yield NumberField::new('noteQuestion', "question.note");
        yield AssociationField::new("moduleThematique", "question.module");

        yield AssociationField::new("bonneReponse", "question.bonneReponse")
            ->hideWhenCreating()
            ->setQueryBuilder(
                fn ($queryBuilder) => $queryBuilder->andWhere("entity.question = :question")->setParameter("question",$this->getContext()->getEntity()->getInstance())
            );

        yield CollectionField::new("reponses")
            ->setEntryIsComplex(true)
            ->setEntryType(ReponseType::class)
            ->allowDelete(true)
            ->hideOnIndex()
            ->setFormTypeOptions([
                'by_reference' => false,
                'required' => true
            ]);
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInSingular("question.singular")->setEntityLabelInPlural("question.plural");
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new("moduleThematique", "question.module"));
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /* @var Question $entityInstance*/
        $bonneReponse = $entityInstance->getBonneReponse();
        if($bonneReponse instanceof Reponse){
            if(!$entityInstance->getReponses()->contains($bonneReponse)){
                $entityInstance->setBonneReponse(null);
                $this->addFlash("warning","question.flash.nullBonneReponse");
            }
        }

        parent::updateEntity($entityManager,$entityInstance);
    }
}
