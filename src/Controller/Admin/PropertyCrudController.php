<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            #ImageField::new('pictureFiles'),
            IntegerField::new('surface'),
            IntegerField::new('rooms'),
            IntegerField::new('bedrooms'),
            IntegerField::new('floor'),
            IntegerField::new('heat')->hideOnIndex(),
            TextField::new('city')->hideOnIndex(),
            TextField::new('address')->hideOnIndex(),
            TextField::new('zip_code')->hideOnIndex(),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category')->hideOnIndex(),
            AssociationField::new('options')->hideOnIndex(),
            AssociationField::new('users'),
            #AssociationField::new('pictures'),
            BooleanField::new('sold'),
            IntegerField::new('lat')->hideOnIndex(),
            IntegerField::new('lng')->hideOnIndex(),
            DateTimeField::new('created_at')->hideOnIndex(),
            DateTimeField::new('updated_at')->hideOnIndex()
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
