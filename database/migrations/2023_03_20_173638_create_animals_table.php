<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('animals', function (Blueprint $table) {
//             $table->id();
//             $table->string('name')->unique();
//             $table->string('breed');
//             $table->integer('age');
//             $table->string('image')->nullable();
//             $table->string('center_id')->constrained()->nullable();
//             $table->text('desc')->nullable();
//             $table->integer('animaltype_id')->nullable();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('animals');
//     }
// };

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('animals', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('breed');
            $table->integer('age');
            $table->text('image')->nullable();
            $table->string('center_id')->constrained()->nullable();
            $table->text('desc')->nullable();
            $table->integer('animaltype_id')->nullable();
            $table->timestamps();
        });

        // Change the 'image' column data type to LONGTEXT using a raw SQL statement
        DB::statement('ALTER TABLE animals MODIFY image LONGTEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('animals');
    }
};

