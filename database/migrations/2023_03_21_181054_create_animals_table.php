<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_id');
            $table->string('code');
            $table->string('race');
            $table->string('genre');
            $table->integer('age');
            $table->integer('weight');
            $table->string('health_condition');
            $table->text('observations');
            $table->string('food');
            $table->string('production');
            $table->date('birth_date');
            $table->boolean('waiting_vet');
            $table->boolean('n_treats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
