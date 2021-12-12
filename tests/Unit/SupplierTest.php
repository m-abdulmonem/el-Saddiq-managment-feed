<?php

namespace Tests\Unit;

use App\Models\Supplier\Supplier;
use App\Services\Supplier\SupplierServices;
use PHPUnit\Framework\TestCase;

class SupplierTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function BillsGraph()
    {
        $supplier = SupplierServices::find(1)->quantityGraph();

//        $supplier;

        $this->assertTrue(false,$supplier);
    }
    
}
