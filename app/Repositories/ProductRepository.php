<?php


namespace App\Repositories;


use App\Contracts\ProductContract;
use App\Models\Product;
use App\Traits\UploadAble;

class ProductRepository extends BaseRepositories implements ProductContract
{
use UploadAble;
    /**
     * @param Product $model
     * @param array $filters
     */
    public function __construct(Product $model, array $filters = [])
    {
        parent::__construct($model, $filters);
    }

    public function new(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->findOneById($id);

        $product->update($data);

        return $product;
    }

    public function destroy($id)
    {
        $product = $this->findOneById($id);

        return $product->delete();
    }

    public function newWithFile($request)
    {
        $data=$request->validated();
        unset($data['image']);
        $record = $this->new($data);
        if ($request->hasFile('image')) $record->update(['image'=>$this->uploadOne($request->image, 'products','public')]);
        return $record;
    }
}
