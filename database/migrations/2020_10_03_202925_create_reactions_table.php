<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->index();
            $table->foreignId('reactable_id');
            $table->string('reactable_type');
            $table->bigInteger('value');
            $table->timestamps();

            // no 'reaction_type_id' in primary means only 1 reaction per user per reactable item
            $table->primary(['user_id', 'reactable_id', 'reactable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reactions');
    }
}
