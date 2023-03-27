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
    private EnderecoRepositoryInterface  $enderecoRepository;

    private function __construct(EnderecoRepositoryInterface $enderecoRepository ){
        $this->enderecoRepository = $enderecoRepository;
    }

    protected $attributes = [
        'name' => 'createEndereco',
        'description' => 'A mutation',
        'model' => 'createEndereco',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Endereco'));
    }

    public function args(): array
    {
        return [
            'street' => [
                'name' => 'street',
                'type' => Type::nonNull(Type::string()),
            ],
            'number' => [
                'name' => 'number',
                'type' => Type::nonNull(Type::string()),
            ],
            'city' => [
                'name' => 'city',
                'type' => Type::nonNull(Type::string()),
            ],
            'country' => [
                'name' => 'country',
                'type' => Type::nonNull(Type::string()),
            ],
            'zip_code' => [
                'name' => 'zip_code',
                'type' => Type::nonNull(Type::string()),
            ],
            'complement' => [
                'name' => 'complement',
                'type' => Type::string(),
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int()),
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
      $this->enderecoRepository->create($args);
    }
}
