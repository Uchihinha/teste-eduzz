<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class Service
{
    protected $modelInstance;

    public function create(array $data) : Model {
        $model = $this->modelInstance->create($data);

        return $model;
    }

    public function find(int $id) : Model {
        $model = $this->modelInstance->findOrFail($id);

        return $model;
    }
}
