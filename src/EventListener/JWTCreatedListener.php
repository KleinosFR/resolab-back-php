<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JWTCreatedListener.
 */
class JWTCreatedListener
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload       = $event->getData();
        $user = $this->manager->getRepository(User::class)->findOneBy(['username' => $payload['username']]);

        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}
