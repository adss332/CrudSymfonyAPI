<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * Class UserPutDTO
 * @package App\DTO
 */
class UserPutDTO
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
     * @inheritdoc
     */
    public function __construct(array $data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
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

}