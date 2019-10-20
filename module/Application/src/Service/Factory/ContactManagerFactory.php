<?php

namespace Application\Service\Factory;

use Application\Service\ContactManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for PostManager. Its purpose is to instantiate the
 * service.
 */
class ContactManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new ContactManager($entityManager);
    }
}