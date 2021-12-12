<?php


namespace App\Services\User\Balances;


use App\Models\Supplier\SupplierBalance;

class SupplierBalanceServices extends SupplierBalance
{

    /**
     * get all record by given user id
     *
     * @param $user
     * @return mixed
     */
    public function ByUser($user)
    {
        return $this->where("user_id",$user)->get();
    }

    /**
     * get all by given supplier id
     *
     * @param $id
     * @return mixed
     */
    public function bySupplier($id)
    {
        return $this->where("supplier_id",$id)->get();
    }
}
