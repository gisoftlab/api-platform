<?php
// api/src/Entity/User.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={"groups"={"user","user.read"}},
 *          "denormalization_context"={"groups"={"user","user.write"}}
 *      },
 *     description="users",
 *     validationGroups="user.write",
 *     itemOperations={
 *         "get",
 *         "put",
 *         "delete",
 *         "view_myself"={
 *             "route_name"="me_view",
 *             "swagger_context"={
 *                  "parameters"={}
 *              },
 *         },
 *         "changePassword"={
 *             "method"="PUT",
 *             "path"="/users/{id}/change-password",
 *             "denormalization_context"={"groups"={"userChangePassword"}},
 *             "validation_groups"={"userChangePassword"},
 *             "swagger_context"={
 *                 "summary" = "Change user password"
 *             }
 *         }
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "id": "exact",
 *          "fullname": "partial",
 *          "email": "partial",
 *          "username": "partial"
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(
 *     OrderFilter::class,
 *          properties={
 *              "id": "ASC",
 *              "fullname": "ASC",
 *              "username": "ASC",
 *              "email": "ASC",
 *              "isActive": "ASC"
 *      }
 *  )
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    const ROLE_USER = "ROLE_USER";
    const ROLE_ADMIN = "ROLE_ADMIN";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({
     *     "user.read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     *
     * @Assert\NotBlank(groups={"user.write"})
     * @Assert\Length(max="50", groups={"user.write"})
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    /**
     * @Assert\NotBlank(groups={"user.write","user.update", "userChangePassword"})
     * @Assert\Length(min="3", max="255", groups={"user.write","user.update", "userChangePassword"})
     * @Groups({
     *     "user.update",
     *     "user.write",
     *     "userChangePassword"
     * })
     * @var string
     */
    public $plainPassword;

    /**
     * @var string
     * @ORM\Column(name="email", length=150, type="string", unique=true)
     * @Assert\NotBlank(groups={"user"})
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true,
     *     groups={"user.write"}
     * )
     * @Assert\Length(max="150", groups={"user.write"})
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $isActive;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     * @Groups({"user.read"})
     */
    private $last_login;

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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"user"})
     * @Groups({
     *     "user"
     * })
     */
    protected $role = self::ROLE_USER;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
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

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [self::ROLE_ADMIN];
        //return [$this->getRole()];
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setFullname(?string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function isUser(?UserInterface $user = null): bool
    {
        return $user instanceof self && $user->id === $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): \DateTime
    {
        return $this->last_login;
    }

    /**
     * @param \DateTime $last_login
     */
    public function setLastLogin(\DateTime $last_login): void
    {
        $this->last_login = $last_login;
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

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
}
