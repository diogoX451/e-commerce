<?php

namespace App\GraphQL\Queries\Address;

use App\Models\Endereco;
use App\Repository\EnderecoRepositoryInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnderecosQuery extends Query
{
    private EnderecoRepositoryInterface $enderecoRepository;

    public function __construct(EnderecoRepositoryInterface $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    protected $attributes = [
        'name' => 'addresses',
        'description' => 'A query',
        'model' => Endereco::class,
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Endereco'));
    }


    public function authorize($root, array $args, $ctx, ?ResolveInfo $resolveInfo = null, ?Closure $getSelectFields = null): bool
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return false;
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return false;
            } else {
                return false;
            }
        }
        return true;
    }

    public function getAuthorizationMessage(): string
    {
        return "Você não tem autorização";
    }


    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
            'street' => [
                'name' => 'street',
                'type' => Type::string(),
            ],
            'number' => [
                'name' => 'number',
                'type' => Type::string(),
            ],
            'city' => [
                'name' => 'city',
                'type' => Type::string(),
            ],
            'state' => [
                'name' => 'state',
                'type' => Type::string(),
            ],
            'country' => [
                'name' => 'country',
                'type' => Type::string(),
            ],
            'zip_code' => [
                'name' => 'zip_code',
                'type' => Type::string(),
            ],
            'complement' => [
                'name' => 'complement',
                'type' => Type::string(),
            ],
            
        ];
    }
    
    public function resolve($root, $args)
    {
        return $this->enderecoRepository->all($args);
    }
}