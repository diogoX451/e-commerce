<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\AcessUserRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\Stock\StockServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserConroler extends Controller
{
    private AcessUserRepositoryInterface $acessRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(AcessUserRepositoryInterface $acessRepository, UserRepositoryInterface $userRepository)
    {
        $this->acessRepository = $acessRepository;
        $this->userRepository = $userRepository;
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        $subQuery = DB::table('product as p')
            ->select(
                'p.name',
                'c.name as Categorias',
                DB::raw("json_build_object(
                'itens_category', json_agg(
                    json_build_object(
                        'name', vpci.name
                    )
                )
            ) as itens_category")
            )
            ->join('category as c', 'p.category_id', '=', 'c.id')
            ->join('variations_products as vp', 'p.id', '=', 'vp.product_id')
            ->join('variationCatOption as vco', 'vp.id', '=', 'vco.variations_products_id')
            ->join('variations_products_category_items as vpci', 'vco.variations_products_category_items_id', '=', 'vpci.id')
            ->groupBy('p.name', 'c.name', 'vp.id');

        $results = DB::table(DB::raw("({$subQuery->toSql()}) as subquery"))
            ->mergeBindings($subQuery)
            ->select(
                'name',
                'Categorias',
                DB::raw("json_build_object('product_variations', json_agg(itens_category)) as product_variations")
            )
            ->groupBy('name', 'Categorias')
            ->get();

        $results->map(function ($item) {
            $item->product_variations = json_decode($item->product_variations);
        });
        return $results;
    }

    public function login(Request $request)
    {
        return $this->acessRepository->login($request);
    }

    public function logout(Request $request)
    {
        $this->acessRepository->logout();
    }
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
