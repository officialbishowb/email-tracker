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
        Schema::create('image_ids', function (Blueprint $table) {
            $table->id();
            $table->string('api_token');
            $table->string('image_id')->unique();
            $table->bigInteger('request_count');
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now());
            $table->foreign('api_token')->references('token')->on('tokens')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_ids');
    }
};
