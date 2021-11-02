<?php

namespace App\Controller\Admin;

use App\Entity\Adoptant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class AdoptantCrudController extends AbstractCrudController
{

    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public function createlinks()
    {
        // if your application only contains one Dashboard, it's enough
        // to define the controller related to this URL
        $url = $this->adminUrlGenerator
            ->setController(AdoptantCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // some actions may require to pass additional parameters
        $url = $this->adminUrlGenerator
            ->setController(AdoptantCrudController::class)
            ->setAction(Action::NEW)
            ->generateUrl();
        // ...
    }
    public static function getEntityFqcn(): string
    {
        return Adoptant::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            EmailField::new('email'),
            TextField::new('plainPassword','Mot de passe')->setRequired(true)->onlyWhenCreating(),
            TextField::new('plainPassword','Mot de passe')->setRequired(false)->onlyWhenUpdating(),
            TextField::new('adresse'),
            TelephoneField::new('telephone'),
            AssociationField::new('ville')
        ];
    }
}
