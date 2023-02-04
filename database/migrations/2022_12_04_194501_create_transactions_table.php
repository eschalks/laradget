<?php

use App\Models\Account;
use App\Models\Category;
use App\Models\CounterParty;
use App\Models\Month;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class)
                  ->constrained();
            $table->string('external_id')
                  ->unique();
            $table->foreignIdFor(Month::class)
                  ->constrained();
            $table->foreignIdFor(Category::class)
                  ->nullable()
                  ->constrained();
            $table->foreignIdFor(CounterParty::class)
                  ->nullable()
                  ->constrained();
            $table->dateTime('transaction_at');
            $table->text('description');
            $table->decimal('amount', 10);
            $table->string('currency');
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
