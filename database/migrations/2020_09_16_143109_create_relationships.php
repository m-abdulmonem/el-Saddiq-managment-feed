<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->foreignId("job_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('attendances', function(Blueprint $table) {
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
//
        Schema::table('balances_clients', function(Blueprint $table) {
            $table->foreignId('bill_id')->nullable()->constrained("bills_clients");
            $table->foreignId('booking_id')->nullable()->constrained("booking_chicks");
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('balances_suppliers', function(Blueprint $table) {
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId('order_id')->nullable()->constrained("chick_orders");
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('balances', function(Blueprint $table) {
            $table->foreignId('supplier_bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId('client_bill_id')->nullable()->constrained("bills_clients");
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('bills_clients', function(Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('bills_suppliers', function(Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('clients_products', function(Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_clients");
            $table->foreignId('stock_id')->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products_prices', function(Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamp('finished_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products_stocks', function(Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('stock_id')->nullable()->constrained();
            $table->timestamp('expired_at');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products_suppliers', function(Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products', function(Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('unit_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products_suppliers_return', function(Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('bills_suppliers_return', function(Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_suppliers");
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('bills_clients_return', function(Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_clients");
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products_clients_return', function(Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_clients_return");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->foreignId("stock_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('chicks', function (Blueprint $table) {
            $table->foreignId("supplier_id")->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('chick_prices', function (Blueprint $table) {
            $table->foreignId("chick_id")->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('chick_orders', function (Blueprint $table) {
            $table->foreignId("chick_id")->nullable()->constrained();
            $table->timestamp("arrived_at")->nullable();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('booking_chicks', function (Blueprint $table) {
            $table->foreignId("chick_id")->nullable()->constrained();
            $table->foreignId("client_id")->nullable()->constrained();
            $table->foreignId("order_id")->nullable()->constrained("chick_orders");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('sms', function (Blueprint $table) {
            $table->foreignId("client_id")->nullable()->constrained();
            $table->foreignId("supplier_id")->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->timestamp("send_at");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
