<?php

namespace App\ArgumentResolver;

use App\DataStructure\Request\RequestDataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Exception\ValidationException;

class RequestDataResolver implements ArgumentValueResolverInterface
{
    const DESERIALIZER_FORMAT = 'json';

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), RequestDataInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $queryData = $request->query->all();
        $requestData = $request->request->all();
        $jsonBodyData = json_decode($request->getContent(), true);
        $allData = array_merge($queryData, $requestData, $jsonBodyData ?? []);
        $data = $this->serializer->serialize($allData, 'json');

        /** @var RequestDataInterface $data */
        $data = $this->serializer->deserialize(
            $data ? $data :'[]',
            $argument->getType(),
            self::DESERIALIZER_FORMAT
        );
        $this->validate($data);

        yield $data;
    }

    /**
     * @param RequestDataInterface $data
     * @throws ValidationException
     */
    private function validate(RequestDataInterface $data)
    {
        $errors = $this->validator->validate($data);
        if (0 !== count($errors)) {
            $json = $this->serializer->serialize($errors, 'json');
            throw new ValidationException($json, 400);
        }
    }
}