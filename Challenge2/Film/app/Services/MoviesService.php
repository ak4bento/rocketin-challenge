<?php

namespace App\Services;

use Request;
use App\Models\Movies;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\DataEmptyException;
use App\Repositories\MoviesRepository;
use Arr;
use Illuminate\Database\Eloquent\Model;
use Validator;

/**
 * code for system logic
 * @property Movies
 * @property MoviesRepository
 */
class MoviesService extends BaseService
{
    /** @var  Movies */
    public $model;

    /** @var  Movies */
    public $repository;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->model = new Movies;
        $this->repository = new MoviesRepository;
    }

    /**
     * [create description]
     * @param  [type] $data [description]
     * @return void [type]       [description]
     * @throws DataEmptyException
     * @throws \App\Exceptions\ValidationException
     */
    public function create($data = null)
    {
        \DB::beginTransaction();

        // create
        $result = $this->model->create($data);

        \DB::commit();

        return $this->repository->getSingleData($result->id);
    }

    /**
     * [update description]
     * @param  [type] $data [description]
     * @return void [type]       [description]
     * @throws DataEmptyException
     * @throws \App\Exceptions\ValidationException
     */
    public function update($id, $data = null)
    {
        \DB::beginTransaction();

        $return = $this->model
            ->where('id',$id)
            ->first();

        if($return === null) throw new DataEmptyException('data Not Exist');
        
        // update
        $result = $this->model->find($id)->update($data);

        \DB::commit();

        return $this->repository->getSingleData($id);
    }
}
