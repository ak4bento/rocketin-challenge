<?php
namespace App\Repositories;

use Request;
use App\Models\Movies;
use App\Exceptions\DataEmptyException;

/**
 * code for system logic
 */
class MoviesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => 'id',
        'title' => 'title',
        'description' => 'description',
        'duration' => 'duration',
        'artists' => 'artists',
        'genres' => 'genres',
    ];

    /**
     * [$module description]
     * @var string
     */
    static $module = 'Movies';

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->model = new Movies;
    }

    /**
     * [getIndexData description]
     * @param  array $sortableAndSearchableColumn [description]
     * @return  void [type]                              [description]
     * @throws DataEmptyException
     * @throws \App\Exceptions\ValidationException
     */
    public function getIndexData($sortableAndSearchableColumn = null)
    {
        $this->validate(Request::all(), [
            'per_page'  =>  'numeric',
        ]);

        $data = $this->model
            ->setSortableAndSearchableColumn($sortableAndSearchableColumn)
            ->select($this->getFieldsSearchable())
            ->search()
            ->sort();
            
        $data = $data->paginate(Request::get('per_page') ? : 10);

        $data->sortableAndSearchableColumn = empty($sortableAndSearchableColumn) ? $sortableAndSearchableColumn : $this->getFieldsSearchable();

        if ($data->total() == 0) throw new DataEmptyException(trans('validation.attributes.dataNotExist', ['attr' => self::$module]));
        
        return $data;
    }

    /**
     * [getSingleData description]
     * @param  [type] $id [description]
     * @return void [type]     [description]
     * @throws DataEmptyException
     */
    public function getSingleData($id)
    {
        $return = $this->model
            ->where('id',$id)
            ->first();

        if($return === null) throw new DataEmptyException('data Not Exist');

        return $return;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Movies::class;
    }
}
