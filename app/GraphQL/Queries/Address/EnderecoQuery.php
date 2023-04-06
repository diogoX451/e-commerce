<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Address;

use App\Models\Endereco;
use App\Repository\EnderecoRepositoryInterface;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class EnderecoQuery extends Query
{
    private  EnderecoRepositoryInterface $enderecoRepository;

    public function __construct(EnderecoRepositoryInterface $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    protected $attributes = [
        'name' => 'address',
        'description' => 'A query',
        'model' => Endereco::class,
    ];

    public function type(): Type
    {
        return Type::listOf(FacadesGraphQL::type('Endereco'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
     return $this->enderecoRepository->getEndereco($args['id']);  
    }
}
