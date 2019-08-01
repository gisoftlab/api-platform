<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

//     collectionOperations={
//        "get",         // get a list of elements
//        "post"         // create new elements
//     },
//     itemOperations={
//        "get",         // get specific element
//        "put",         // update element
//        "delete"       // delete element
//     }

/**
 * This is a dummy entity. Remove it!
 *
 * @ApiResource(
 *     collectionOperations={
 *        "get",
 *        "post"
 *     },
 *     itemOperations={
 *        "get",
 *        "put",
 *        "delete"
 *     }
 * )
 * @ApiFilter(OrderFilter::class, properties={"id": "ASC", "name": "DESC"})
 * @ORM\Entity
 */
class Greeting
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string A nice person
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    public $name = '';

    public function getId(): int
    {
        return $this->id;
    }
}
