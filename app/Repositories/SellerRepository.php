<?php


namespace App\Repositories;


use App\Contracts\SellerContract;
use App\Models\Seller;

class SellerRepository extends BaseRepositories implements SellerContract
{

    /**
     * @param Seller $model
     * @param array $filters
     */
    public function __construct(Seller $model, array $filters = [])
    {
        parent::__construct($model, $filters);
    }

    public function new(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $seller = $this->findOneById($id);

        $seller->update($data);

        return $seller;
    }

    public function destroy($id)
    {
        $seller = $this->findOneById($id);

        return $seller->delete();
    }
}
