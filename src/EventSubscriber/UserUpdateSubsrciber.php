<?php

namespace App\EventSubscriber;

use App\Entity\Admin;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUpdateSubsrciber implements EventSubscriberInterface
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['onBeforeEntityPersistedEvent'],
            BeforeEntityUpdatedEvent::class => ['onBeforeEntityPersistedEvent']
        ];
    }

    public function onBeforeEntityPersistedEvent($event)
    {
        $user = $event->getEntityInstance();
        if (!$user instanceof Admin && !$user instanceof Utilisateur) {
            return;
        }
        if (empty($user->getPlainPassword())) {
            return;
        }
        $pwd = $this->hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($pwd);
    }
}
