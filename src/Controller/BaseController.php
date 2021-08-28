<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BaseController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     * @required
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function response($data, $groups = [], $error = null, $statusCode = Response::HTTP_OK): Response
    {
        $responseData = [
            'data' => $data,
            'error' => $error
        ];

        return new Response(
            $this->serializer->serialize($responseData, 'json', [
                'groups' => $groups
            ]),
            $statusCode,
            ['Content-type' => 'application/json']
        );
    }
}