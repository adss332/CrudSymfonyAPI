<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="This email is already used.")
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $first_name;

    /**
     * @ORM\Column(type="string")
     */
    private string $last_name;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private int|null $parent_id = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable",nullable=true)
     */
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $soft_delete = false;

    /**
     * @ORM\Column(type="datetime_immutable",nullable=true)
     */
    private ?\DateTimeImmutable $deletedAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(int|null $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isSoftDelete(): bool
    {
        return $this->soft_delete;
    }

    public function setSoftDelete(bool $soft_delete): self
    {
        $this->soft_delete = $soft_delete;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
