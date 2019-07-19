<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->integerIncrements('id');

            $table->string('name', 100)
                ->index();

            $table->string('photo')
                ->index();

            $table->timestamp('created_at')
                ->nullable()
                ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamp('updated_at')
                ->nullable()
                ->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
