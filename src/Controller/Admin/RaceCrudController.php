<?php

namespace App\Controller\Admin;

use App\Entity\Race;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class RaceCrudController extends AbstractCrudController
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
            ->setController(RaceCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // some actions may require to pass additional parameters
        $url = $this->adminUrlGenerator
            ->setController(AnnonceurCrudController::class)
            ->setAction(Action::NEW)
            ->generateUrl();

        // ...
    }
    public static function getEntityFqcn(): string
    {
        return Race::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            'nom'
        ];
    }

}
