<?php

declare(strict_types=1);

namespace App\Services\Stock;

use App\Repository\StockRepositoryInterface;
use Illuminate\Support\Str;

class StockServices {
    
    private $stockRepository = [];
    private $uuid;

    private function __construct(StockRepositoryInterface $stockRepository){
        $this->uuid = Str::uuid()->toString();
        $this->stockRepository = $stockRepository;
        
    }

    public function createCategory($category){
        $category['id'] = $this->uuid;
        $this->stockRepository->createCategory($category);
    }    
}