<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"account.read"}},
 *     "denormalization_context"={"groups"={"account.write"}}
 * },
 * itemOperations={
 *  "put"={"denormalization_context"={"groups"={"account.update"}}},
    "get",
    "delete"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ApiFilter(SearchFilter::class, properties={"id": "exact","username": "partial"})
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(OrderFilter::class, properties={"id": "ASC", "username": "DESC"})
 * @ApiFilter(PropertyFilter::class, arguments={"parameterName": "username"})
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({
     *     "account.read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Please provide username")
     * @Groups({
     *     "account.read",
     *     "account.write"
     * })
     */
    private $username;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     * @Groups({
     *     "account.read",
     *     "account.write",
     *     "account.update"
     * })
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="accounts")
     * @ApiSubresource(maxDepth=1)
     * @Groups({
     *     "account.read"
     * })
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please provide password")
     * @Groups({
     *     "account.write",
     *     "account.update"
     * })
     */
    private $password;


    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addAccount($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeAccount($this);
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
