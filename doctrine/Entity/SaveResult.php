<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaveResult
 *
 * @ORM\Table(name="save_result")
 * @ORM\Entity
 */
class SaveResult
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="result_json", type="text", length=65535, nullable=true)
     */
    private $resultJson;


}
