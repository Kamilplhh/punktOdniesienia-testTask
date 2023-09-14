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
            $table->string('file');
            $table->string('title');
            $table->string('email')->nullable();
            $table->boolean('paid')->default(false);
            $table->float('price', 8, 2);
            $table->date('paymentDate'); 
            $table->Integer('bank')->nullable();
            $table->Integer('nip')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('recipient')->nullable();
            $table->string('adress')->nullable();
            $table->string('content')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('contractor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
