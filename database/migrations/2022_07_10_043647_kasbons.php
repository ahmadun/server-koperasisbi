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
        Schema::create('kasbons', function (Blueprint $table) {
            $table->id();
            $table->char('nik', 6);
            $table->date('date_bon');
            $table->char('form',1);
            $table->char('nota',10);
            $table->string('item');
            $table->integer('qty');
            $table->integer('price');
            $table->string('created_by',15);
            $table->string('updated_by',15)->nullable();
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
        Schema::dropIfExists('kasbons');
    }
};
