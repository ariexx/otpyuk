<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id', 5)->unique(); //id yang didapatkan dari API contoh : at, aj, uk, go
            $table->integer('operator_id')->default(1);
            $table->integer('rate_id')->default(1);
            // $table->foreignId('operator_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('rate_id')->constrained()->cascadeOnDelete();
            $table->string('service_name', 25);
            $table->float('provider_price');
            $table->integer('price');
            $table->integer('discount')->default(0)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('services');
    }
};
