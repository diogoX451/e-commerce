<?php

namespace App\Repository\Implements\Endereco;

use App\Models\Endereco;
use App\Repository\EnderecoRepositoryInterface;

class EnderecoRepository implements EnderecoRepositoryInterface{
    
        public function all()
        {
            return Endereco::all();
        }
        public function getEndereco($id)
        {
            $findId = $id;
            return Endereco::where('id', $findId)->get();
        }
        public function create($request)
        {
            $endereco = validator($request, [
                'street' => 'required',
                'number' => 'required',
                'state' => 'required',
                'city' => 'required',
                'country' => 'required',
                'zip_code' => 'required',
                'complement' => 'required',
                'users_id' => 'required'
            ]);

            if ($endereco->fails()) {
                return $endereco->errors();
            }

            $endereco = Endereco::create($request);
            $endereco->users()->attach($request['users_id'] );
            
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