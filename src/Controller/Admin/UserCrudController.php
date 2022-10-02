<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        EntityManagerInterface $em,
        RequestStack $requestStack
    )
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $displayCompanyField = User::displayCompanyField(
            $this->requestStack, 
            $this->em
        );

        yield EmailField::new('email');
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield TextField::new('phoneNumber');
        yield TextField::new('plainTextPassword')
        ->hideOnIndex()
        ->setLabel('Password');
        yield ArrayField::new('roles');

        // Compare current page and chosen user group.
        if($pageName === Crud::PAGE_INDEX || ($pageName !== Crud::PAGE_INDEX && $displayCompanyField)){   
            yield AssociationField::new('company')
            ->setFormTypeOptions([
            'multiple' => false, 
            ])->setCrudController(Company::class) ;
        }
    }

   
 
}
