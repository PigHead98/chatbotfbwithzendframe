<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as Mapping;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="Contact")
 */
class Contact
{

    /**
     * @Mapping\Id
     * @Mapping\GeneratedValue
     * @Mapping\Column(name="id")
     */
    protected $id;

    /**
     * @Mapping\Column(name="name")
     */
    protected $name;

    /**
     * @Mapping\Column(name="email")
     */
    protected $email;

    /**
     * @Mapping\Column(name="phone")
     */
    protected $phone;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}