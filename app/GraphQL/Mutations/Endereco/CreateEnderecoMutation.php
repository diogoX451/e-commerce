<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Endereco;

use App\Repository\EnderecoRepositoryInterface;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateEnderecoMutation extends Mutation
{
    private EnderecoRepositoryInterface $enderecoRepository;

    public function __construct(EnderecoRepositoryInterface $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    protected $attributes = [
        'name' => 'createEndereco',
        'description' => 'Criação de Endereço com Usuario'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Endereco'));
    }

    public function args(): array
    {
        return [
            "street" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The street of the address"
            ],
            "number" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The number of the address"
            ],
            "city" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The city of the address"
            ],
            "state" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The state of the address"
            ],
            "country" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The country of the address"
            ],
            "zip_code" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The postal code of the address"
            ],
            "complement" => [
                "type" => Type::string(),
                "description" => "The complement of the address"
            ],
            "users_id" => [
                "type" => Type::nonNull(Type::int()),
                "description" => "The id of the user"
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $this->enderecoRepository->create($args);
    }
}
