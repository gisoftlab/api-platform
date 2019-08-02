<?php

namespace App\Swagger;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;
    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }
    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        /**
         *  Custom Swagger description
         */
        $docs['paths']['/authentication_token'] = [
            'post' => [
                'tags' => ['login'],
                'summary' => 'Login to app',
                'parameters' => [
                    [
                        'name' => 'login',
                        'description' => 'The Login resource',
                        'example' => [
                            "email" => "string",
                            "password" => "string",
                        ],
                        'in' => 'body',
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'The Login resource',
                        'example' => [
                            'token' => 'string'
                        ]
                    ],
                ]
            ]
        ];
        return $docs;
    }
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}


