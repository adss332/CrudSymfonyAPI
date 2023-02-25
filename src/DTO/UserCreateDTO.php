<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * Class UserCreateDTO
 * @package App\DTO
 */
class UserCreateDTO
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private string $first_name;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private string $last_name;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     * )
     */
    private string $email;

    /**
     * @Assert\Type(type="integer")
     */
    private int|null $parentId;

    public function __construct(array $data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->parentId = $data['parentId'];
    }

    /**
     * @return array
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