<?php

namespace Application\Controller;

use Application\Form\ContactForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * Entity manager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Contact manager.
     *
     * @var Application\Service\ContactManager
     */
    private $contactManager;

    public function __construct($entityManager, $contactManager)
    {
        $this->entityManager  = $entityManager;
        $this->contactManager = $contactManager;
    }

    public function addAction()
    {
        $obj = json_decode(file_get_contents('php://input'), true);
        if (isset($obj['name']))
        {
            $this->contactManager->addNewContact(
                [
                    'name'  => $obj['name'],
                    'email' => $obj['email'],
                    'phone' => $obj['phone'],
                ]
            );
        }
        die;
        // Create the form.
        $form = new ContactForm();

        //check method
        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {

                $data = $form->getData();

                $this->contactManager->addNewContact($data);

                return $this->redirect()->toRoute('application');
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}