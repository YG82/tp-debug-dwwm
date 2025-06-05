<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Données de l\'utilisateur')
                ->setIcon('fa fa-user')
                ->setHelp('Panneau contenant des infos de base.'),
            TextField::new('username')
                ->setHelp("Il s'agit d'un nom différent de l'adresse email."),
            EmailField::new('email')
                ->setHelp("Saisir une adresse email."),
            ImageField::new('image')
                ->setHelp("Image de profile de l'utilisateur.")
                ->setBasePath('media/images')
                ->setUploadDir('public/media/images')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                ->setFileConstraints(new Image(maxSize: '10M')),
            FormField::addTab('Actions sensibles')
                ->setIcon('fa fa-warning')
                ->setHelp('Panneau contenant des actions sensibles.'),
            BooleanField::new('isMajor')
                ->hideOnIndex()
                ->setHelp("L'utilisateur est majeur."),
            BooleanField::new('isGpdr')
                ->hideOnIndex()
                ->setHelp("L'utilisateur a accepté la politique de confidentialité."),
            BooleanField::new('isTerms')
                ->hideOnIndex()
                ->setHelp("L'utilisateur a accepté les conditions d'utilisation."),
            BooleanField::new('isBanned')
                ->hideOnIndex()
                ->setHelp("Bannir l'utilisateur ?"),
        ];
    }
}
