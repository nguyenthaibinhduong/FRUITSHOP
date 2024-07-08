<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
        $table->string('order_code')->unique();
        $table->unsignedBigInteger('user_id');
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_tel');
        $table->string('customer_address');
        $table->decimal('total', 10, 2);
        $table->decimal('total_price', 10, 2);
        $table->string('payment_method');
        $table->decimal('discount', 10, 2);
        $table->unsignedBigInteger('status');
        $table->timestamps();
        $table->softDeletes();
        
        $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        $table->foreign('status')->references('id')->on('order_statuses')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
