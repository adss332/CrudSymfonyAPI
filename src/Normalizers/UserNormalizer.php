<?php

namespace App\Normalizers;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data);
    }

    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if ($context['mode'] === 'default' && $object instanceof User) {
            $userArray = [
                'first_name' => $object->getFirstName(),
                'last_name' => $object->getLastName(),
                'email' => $object->getEmail(),
                'createdAt' => $object->getCreatedAt(),
                'updatedAt' => $object->getUpdatedAt(),
            ];

            return $this->normalizeDateTimeProperties($userArray);
        }

        return [];
    }

    /**
     * @param array $objectArray
     * @return array
     */
    private function normalizeDateTimeProperties(array $objectArray): array
    {
        foreach ($objectArray as $key => $value) {
            if ($value instanceof \DateTimeInterface) {
                $objectArray[$key] = $value->format(\DateTimeInterface::ATOM);
            }
        }
        return $objectArray;
    }

}