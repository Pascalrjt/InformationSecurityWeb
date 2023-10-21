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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            // $table->text('imageAE');
            // $table->string('key');
            $table->longText('imageBase64AES')->nullable();
            $table->longText('imageBase64RC4')->nullable();
            $table->longText('imageBase64DES')->nullable();
            $table->string('keyAES')->nullable();
            $table->string('keyRC4')->nullable();
            $table->string('keyDES')->nullable();
            $table->boolean('is_admin')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        // Change the 'idcard' column data type to LONGTEXT using a raw SQL statement
        // DB::statement('ALTER TABLE users MODIFY image LONGTEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
