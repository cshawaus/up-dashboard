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

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('account_id')
                ->nullable()
                ->constrained('accounts')
                ->onDelete('cascade');

            $table->string('description')->index();
            $table->text('message')->nullable();
            $table->uuid('identifier');
            $table->string('created', 40);
            $table->string('settled', 40)->nullable();
            $table->enum('status', ['HELD', 'SETTLED']);
            $table->json('hold_info')->nullable();
            $table->decimal('amount');
            $table->string('currency_code', 4);
            $table->json('round_up')->nullable();
            $table->json('cashback')->nullable();
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
