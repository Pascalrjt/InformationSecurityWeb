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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('extension');
            $table->text('file_base64');
            $table->unsignedBigInteger('fileOwner');
            $table->foreign('fileOwner')->references('id')->on('users');
            $table->timestamps();

        });

        DB::statement('ALTER TABLE files MODIFY file_base64 LONGTEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
