<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('tmn_code')->nullable();
            $table->string('txnref')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('note')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bank_code')->nullable();
            $table->bigInteger('amount')->default(0)->nullable();
            $table->string('service_code')->nullable()->index();
            $table->char('status')->nullable()->comment('PENDING | APPROVED| CANCEL');
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
        Schema::dropIfExists('payment_transaction');
    }
}
