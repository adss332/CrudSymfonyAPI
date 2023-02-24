<?php


namespace App\Controller;

use App\DTO\UserDataDTO;
use App\Services\UserService\UserServiceInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Класс, реализующий API для функционала пользователей
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var SerializerInterface
     */

    private $serializer;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userService
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        UserServiceInterface $userService,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    )
    {
        $this->userService = $userService;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * Создание пользователя
     * @OA\Tag(name="User")
     * @OA\RequestBody(required=True,
     *     @OA\JsonContent(
     *     @OA\Property(property="first_name", type="string", description="Имя"),
     *     @OA\Property(property="last_name", type="string", description="Фамилия"),
     *     @OA\Property(property="email", type="string", description="Email"),
     *     @OA\Property(property="parentId", type="integer", nullable=true, default=null, description="Идентификатор родителя"),
     *     )
     * )
     *
     * @Rest\Post("api/users")
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $userInfo = new UserDataDTO($request->toArray());

        $violations = $this->validator->validate($userInfo);

        if (count($violations) > 0) {
            return new JsonResponse(
                ['message' => (string) $violations],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $userId = $this->userService->createUser($userInfo);
        } catch (Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            ['id' => $userId]
        );
    }

    /**
     * Получение информации о всех пользователях
     * @Rest\Get("/api/users/{page}/{limit}", requirements={"page"="\d+", "limit"="\d+"})
     * @OA\Tag(name="User")
     * @OA\Parameter(
     *     name="page",
     *     in="path",
     *     description="Номер страницы",
     *     required=false,
     *     @OA\Schema(
     *         type="integer",
     *         minimum=1
     *     )
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="path",
     *     description="Количество элементов на странице",
     *     required=false,
     *     @OA\Schema(
     *         type="integer",
     *         minimum=1,
     *         maximum=100
     *     )
     * )
     *
     * @param int|null $page
     * @param int|null $limit
     * @return JsonResponse
     */
    public function getAllUsers(?int $page, ?int $limit): JsonResponse
    {
        try {
            $result = [];
            $users = $this->userService->getUsersByPageAndLimit($page, $limit);
            foreach ($users as $user) {
               $result[] = $this->serializer->normalize($user,'json',['mode'=>'default']);
            }
        } catch (EntityNotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
                'users' => $result
            ]
        );
    }

    /**
     * Изменение данных пользователя
     * @Rest\Put("/api/users/{id}", requirements={"id"="\d+"})
     * @OA\Tag(name="User")
     * @OA\RequestBody(required=True,
     *     @OA\JsonContent(
     *     @OA\Property(property="first_name", type="string", description="Имя"),
     *     @OA\Property(property="last_name", type="string", description="Фамилия"),
     *     @OA\Property(property="email", type="string", description="Email"),
     *     @OA\Property(property="parentId", type="integer", nullable=true, default=null, description="Идентификатор родителя"),
     *     )
     * )
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="Идентификатор",
     * required=true,
     * @OA\Schema(type="integer")
     * )
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function editUserById(Request $request, int $id): JsonResponse
    {
        $userInfo = new UserDataDTO($request->toArray());

        $violations = $this->validator->validate($userInfo);

        if (count($violations) > 0) {
            return new JsonResponse(
                ['message' => (string) $violations],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $userId = $this->userService->editUser($userInfo, $id);
        } catch (EntityNotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse([
                'id' => $userId
            ]
        );
    }

    /**
     * Получение информации о пользователе по идентификатору
     * @Rest\Get("/api/users/{id}", requirements={"id"="\d+"})
     * @OA\Tag(name="User")
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="Идентификатор",
     * required=true,
     * @OA\Schema(type="integer")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUserById(int $id): JsonResponse
    {
        try {
            $result = $this->userService->getUserById($id);
        } catch (EntityNotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->serializer->normalize($result,'json',['mode'=>'default'])
        );
    }

    /**
     * Удаление пользователя
     * @Rest\Delete("/api/user/{id}", requirements={"id"="\d+"})
     * @OA\Tag(name="User")
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="Идентификатор",
     * required=true,
     * @OA\Schema(type="integer")
     * )
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteUserById(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }
        return new JsonResponse([
            'id' => $id
        ]);
    }
}