<?php


namespace App\Services\Balances;


use App\Models\Client\ClientBalance;
use App\Models\Supplier\SupplierBalance;

class BalancesServices
{

    /**
     * @var ClientBalance
     */
    private $client;
    /**
     * @var SupplierBalance
     */
    private $supplier;

    /**
     * BalancesServices constructor.
     * @param ClientBalance $client
     * @param SupplierBalance $supplier
     */
    public function __construct(ClientBalance $client, SupplierBalance $supplier)
    {

        $this->client = $client;
        $this->supplier = $supplier;
    }


    public function supplier($data)
    {
        return datatables()->of( $data )
            ->addIndexColumn()
            ->addColumn("supplier",function ($data){
                return $this->supplierLink($data);
            })
            ->addColumn("type",function ($data){
                return $data->name();
            })
            ->addColumn("paid",function ($data){
                return currency( $data->paid );
            })
            ->addColumn("remaining",function ($data){
                return currency( $data->remaining_amount );
            })
            ->addColumn("date",function ($data){
                return $data->created_at->diffForHumans();
            })
            ->addColumn("user",function ($data){
                return $this->userLink($data);
            })
            ->rawColumns(['supplier','user'])
            ->make(true);
    }


    public function client($data)
    {
        return datatables()->of( $data )
            ->addIndexColumn()
            ->addColumn("client",function ($data){
                return $this->clientLink($data);
            })
            ->addColumn("type",function ($data){
                return $data->name();
            })
            ->addColumn("paid",function ($data){
                return currency( $data->paid );
            })
            ->addColumn("rest",function ($data){
                return currency( $data->remaining_amount );
            })
            ->addColumn("date",function ($data){
                return $data->created_at->diffForHumans();
            })
            ->addColumn("user",function ($data){
                return $this->userLink($data);
            })
            ->rawColumns(['client','user'])
            ->make(true);
    }
    
    
    /**
     * redirect route to Supplier page profile
     *
     * @param $data
     * @return string
     */
    private function supplierLink($data)
    {
        $route = route("suppliers.show",$data->supplier->id);

        return "<a class='info-color' href='$route'>{$data->supplier->name()}</a>";
    }

    /**
     * redirect route to Supplier page profile
     *
     * @param $data
     * @return string
     */
    private function clientLink($data)
    {
        $route = route("clients.show",$data->clients->id) ;

        return "<a class='info-color' href='$route'>{$data->clients->name()}</a>";
    }



    /**
     * redirect route to user page profile
     *
     * @param $data
     * @return string
     */
    private function userLink($data)
    {
        return "<a class='info-color' href='" . route("users.show",$data->user->id) . "'>{$data->user->name()}</a>";
    }


}
