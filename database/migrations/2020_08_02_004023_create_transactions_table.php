<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
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
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->string('description')->index();
            $table->text('message')->nullable();
            $table->uuid('identifier');
            $table->dateTimeTz('created');
            $table->dateTimeTz('settled')->nullable();
            $table->string('type');
            $table->json('hold_info');
            $table->decimal('amount');
            $table->string('currency_code', 4);
            $table->boolean('round_up')->nullable();
            $table->boolean('cashback')->nullable();
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['account_identifier']);
        });

        Schema::dropIfExists('transactions');
    }
}
