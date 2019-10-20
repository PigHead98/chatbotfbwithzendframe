<?php

namespace Application\Controller\Factory;

use Application\Controller\ContactController;
use Application\Service\ContactManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager  = $container->get('doctrine.entitymanager.orm_default');
        $contactManager = $container->get(ContactManager::class);

        return new ContactController($entityManager, $contactManager);
    }
}