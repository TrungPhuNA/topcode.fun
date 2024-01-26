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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('vi');
            $table->string('partner_code')->nullable();
            $table->string('service')->nullable();
            $table->string('identifier_id')->nullable(); // mã liên kết với đơn hàng của khách
            $table->bigInteger('amount')->default(0); // tỏng tiền
            $table->string('url_success')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
