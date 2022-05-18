<?php


namespace Admin;

namespace App\Admin\Filter;

use App\Form\RelationType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\EntityFilterType;

class RelationFilter implements FilterInterface
{
    use FilterTrait;

    protected $alias;

    public static function new(string $propertyName,string $choiceLabel, string $class, $label = null): self
    {
        $parts = explode('.', $propertyName);

        $filter =  (new self())
            ->setFilterFqcn(__CLASS__)
            ->setAlias($parts[0])
            ->setProperty(str_replace('.','_',$propertyName))
            ->setLabel($label)
            ->setFormTypeOption('mapped', false)
            ->setFormType(EntityFilterType::class)
            ->setFormTypeOption('value_type_options', [
                'class' => $class,
                'multiple' => true,
                "choice_label"=>$choiceLabel,
                'query_builder' => function (EntityRepository $repository) use ($choiceLabel) {
                    return $repository
                        ->createQueryBuilder('r')
                        ->orderBy(sprintf("r.%s",$choiceLabel), 'ASC');
                }
            ]);

        return $filter;
    }


    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $properties = explode("_",$filterDataDto->getProperty());
        $comparison = $filterDataDto->getComparison();
        $entities = $filterDataDto->getValue();
        $parameterName = ":entities";

        $base = "entity";
        foreach ($properties as $property){
            $queryBuilder->innerJoin(sprintf("%s.%s",$base,$property),$property);
            $base = $property;
        }
        $queryBuilder->andWhere(sprintf('%s %s (%s)', $base, $comparison,$parameterName))
            ->setParameter($parameterName, $entities->toArray());
    }
}