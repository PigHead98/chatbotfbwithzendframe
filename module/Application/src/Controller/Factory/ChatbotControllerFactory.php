<?php

namespace Application\Controller\Factory;

use Application\Controller\ChatbotController;
use Application\Service\ContactManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ChatbotControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager  = $container->get('doctrine.entitymanager.orm_default');
        $contactManager = $container->get(ContactManager::class);

        return new ChatbotController($entityManager,$contactManager);
    }
}