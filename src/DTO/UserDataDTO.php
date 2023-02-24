<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * Class UserDataDTO
 * @package App\DTO
 */
class UserDataDTO
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $first_name;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $last_name;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     * )
     * @Assert\Unique(entityClass="App\Entity\User", message="This email is already used.")
     */
    private $email;

    /**
     * @var int|null
     * @Assert\Type(type="integer")
     */
    private $parentId;

    /**
     * @inheritdoc
     */
    public function __construct(array $data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->parentId = $data['parentId'];
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'parentId' => $this->parentId,
        ];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

}