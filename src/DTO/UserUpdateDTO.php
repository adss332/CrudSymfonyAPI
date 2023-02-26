<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * Class UserUpdateDTO
 * @package App\DTO
 */
class UserUpdateDTO
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private string $firstName;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private string $lastName;

    public function __construct(array $data)
    {
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->lastName,
        ];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

}