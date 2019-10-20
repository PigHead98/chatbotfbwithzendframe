<?php

namespace Application\Service;

use Application\Entity\Contact;
use Application\Entity\Save_result;


// This service is responsible for adding new contact.
class ContactManager
{
    /**
     * Doctrine entity manager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // This method adds a new Contact.
    public function addNewContact($data)
    {
        $contact = new Contact();
        $contact->setName($data['name']);
        $contact->setEmail($data['email']);
        $contact->setPhone($data['phone']);

        $this->entityManager->persist($contact);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    public function addResult($data)
    {
        $result = new Save_result();
        $result->setJson(json_encode($data));

        $this->entityManager->persist($result);
        // Apply changes to database.
        $this->entityManager->flush();
    }

}