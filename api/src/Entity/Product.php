<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\MediaObject;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use App\Controller\ProductsSpecial;
use App\Controller\CreateProductPublication;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

//= {"method"="GET","access_control"="is_granted('custom_action', object)"},
/**
 * Product entity
 *
 * @ApiResource(
 *     attributes={
 *     "access_control"="is_granted('ROLE_ADMIN')",
 *     "normalization_context"={"groups"={"product","product.read"}},
 *     "denormalization_context"={"groups"={"product","product.write"}}
 * },
 * itemOperations={
 *   "put",
 *   "get",
 *   "delete",
 *   "post_publication"={
 *         "method"="POST",
 *         "path"="/product/{id}/publication",
 *         "controller"=CreateProductPublication::class,
 *         "read"=false,
 *         "swagger_context"= {
 *                  "summary"= "make product publicated.",
 *                  "description"= "Products a page (i.e. help, terms, privacy)",
 *                  "parameters"= {
 *                      {
 *
 *                      },
 *                  },
 *              },
 *   }
 *
 * })
 * @ApiFilter(
 *     OrderFilter::class,
 *          properties={
 *              "id": "ASC",
 *              "title": "ASC",
 *              "short": "ASC",
 *              "published": "ASC",
 *              "price": "ASC"
 *      }
 *  )
 * @ORM\Table(name="products__product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ApiFilter(NumericFilter::class, properties={"title"})
 * @ORM\HasLifecycleCallbacks()
 */
class Product {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"product:read"})
     */
    private $id;

    /**
     * @var string $title
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Initial weight lbs cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank(message="Please provide title")
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     *
     * @Groups({"product"})
     */
    private $title;

    /**
     * @var string $short
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Initial weight lbs cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank(message="Please provide title")
     * @ORM\Column(name="short", type="text", nullable=true)
     * @Groups({"product.write"})
     */
    private $short;

    /**
     * @var string $description

     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Groups({"product"})
     */
    private $description;

    /**
     * @var boolean $published
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     *
     * @Groups({"product"})
     */
    private $published = true;

    /**
     * @var boolean $promoted
     *
     * @ORM\Column(name="promoted", type="boolean", nullable=true)
     *
     * @Groups({"product"})
     */
    private $promoted = false;

    /**
     * @var float $price
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 1000000,
     *      minMessage = "This value should be {{ limit }} or more",
     *      maxMessage = "This value should be {{ limit }} or less"
     * )
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=true)
     *
     * @Groups({"product"})
     */
    private $price = 0;

    /**
     * @var float $deposit
     * @Assert\Range(
     *      min = 0,
     *      max = 1000000,
     *      minMessage = "This value should be {{ limit }} or more",
     *      maxMessage = "This value should be {{ limit }} or less"
     * )
     * @ORM\Column(name="deposit", type="decimal", scale=2, nullable=true)
     *
     * @Groups({"product"})
     */
    private $deposit = 0;


    /**
     * @ApiSubresource()
     *
     * @ORM\OneToMany(
     *   targetEntity="ProductItems",
     *   mappedBy="product",
     *   cascade={"persist"}
     * )
     */
    private $items;


    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     */
    public $image;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var
     */
    private $result;

    public function __construct() {
        $this->items = new ArrayCollection();
    }


    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set short
     *
     * @param string $short
     */
    public function setShort($short) {
        $this->short = $short;
    }

    /**
     * Get short
     *
     * @return string $short
     */
    public function getShort() {
        return $this->short;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set published
     *
     * @param boolean $published
     */
    public function setPublished($published) {
        $this->published = $published;
    }

    /**
     * Get published
     *
     * @return boolean $published
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set promoted
     *
     * @param $promoted
     * @internal param bool $published
     */
    public function setPromoted($promoted) {
        $this->promoted = $promoted;
    }

    /**
     * Get promoted
     *
     * @return boolean $promoted
     */
    public function getPromoted() {
        return $this->promoted;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price) {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set deposit
     *
     * @param float $deposit
     */
    public function setDeposit($deposit) {
        $this->deposit = $deposit;
    }

    /**
     * Get deposit
     *
     * @return float
     */
    public function getDeposit() {
        return $this->deposit;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems() {
        return $this->items ? : $this->items = new ArrayCollection();
    }

    /**
     * Sets the user Items
     *
     * @param array $items
     */
    public function setItem(Array $items) {

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * Add a order
     *
     * @param ProductItems $item
     * @return $this
     */
    public function addItem(ProductItems $item) {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
        }

        return $this;
    }


    /**
     * @param ProductItems $item
     * @return $this
     */
    public function removeItem(ProductItems $item) {
        if ($this->getItems()->contains($item)) {
            $this->getItems()->removeElement($item);
        }

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    // ---
    // --- LIFECYCLECALLBACKS ACTIONS
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }


}

