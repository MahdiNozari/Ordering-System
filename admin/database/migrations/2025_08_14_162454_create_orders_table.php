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

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained()->nullable()->onDelete('cascade');
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('total_amoumt');
            $table->unsignedInteger('coupon_amoumt')->default(0);
            $table->unsignedInteger('paying_amoumt');
            $table->tinyInteger('payment_status')->default(0);
            $table->softDeletes();

            $table->timestamps();
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
