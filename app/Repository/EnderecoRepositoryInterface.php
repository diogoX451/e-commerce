<?php

namespace App\Repository;

interface EnderecoRepositoryInterface
{
    public function all();
    public function getEndereco($id);
    public function create($request);
    public function update($request, $id);
    public function delete($id);
}