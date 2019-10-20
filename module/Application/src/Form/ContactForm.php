<?php

namespace Application\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ContactForm extends Form
{
    public function __construct()
    {
        parent::__construct('contact-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {

        $this->add([
            'type'       => Text::class,
            'name'       => 'name',
            'attributes' => [
                'id' => 'name',
            ],
            'options'    => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'type'       => Text::class,
            'name'       => 'email',
            'attributes' => [
                'id' => 'email',
            ],
            'options'    => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'type'       => Text::class,
            'name'       => 'phone',
            'attributes' => [
                'id' => 'phone',
            ],
            'options'    => [
                'label' => 'Phone',
            ],
        ]);

        $this->add([
            'type'=> 'submit',
            'name'=> 'submit',
            'attributes' => [
                'value' => 'submit',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'       => 'name',
            'required'   => true,
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'       => 'email',
            'required'   => true,
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'       => 'phone',
            'required'   => true,
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 15,
                    ],
                ],
            ],
        ]);

    }
}