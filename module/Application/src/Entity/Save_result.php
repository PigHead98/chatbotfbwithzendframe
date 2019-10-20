<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as Mapping;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="save_result")
 */
class Save_result
{

    /**
     * @Mapping\Id
     * @Mapping\GeneratedValue
     * @Mapping\Column(name="id")
     */
    protected $id;

    /**
     * @Mapping\Column(name="result_json")
     */
    protected $result_json;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getJson()
    {
        return $this->result_json;
    }

    public function setJson($json)
    {
        $this->result_json = $json;
    }

}