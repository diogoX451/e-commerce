<?php

namespace App\Repository\Implements\Endereco;

use App\Models\Endereco;
use App\Repository\EnderecoRepositoryInterface;

class EnderecoRepository implements EnderecoRepositoryInterface{
    
        public function all()
        {
            return Endereco::all();
        }
        public function find($id)
        {
            return Endereco::find($id);
        }
        public function create($request)
        {
            $endereco = validator($request, [
                'street' => 'required',
                'number' => 'required',
                'city' => 'required',
                'country' => 'required',
                'zip_code' => 'required',
                'complement' => 'required',
                'user_id' => 'required'
            ]);

            if ($endereco->fails()) {
                return $endereco->errors();
            }

            //user_id is required
            $endereco = Endereco::create($request);
            $endereco->users()->attach($request['user_id']);
            return $endereco;
        }
        public function update($request, $id)
        {
            $endereco = Endereco::find($id);
            $endereco->update($request);
            return $endereco;
        }
        public function delete($id)
        {
            $endereco = Endereco::find($id);
            $endereco->delete();
            return $endereco;
        }

}