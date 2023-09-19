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
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->string('email')->nullable();
            $table->string('file')->nullable();
            $table->string('contractor')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->Integer('bank')->nullable();
            $table->Integer('nip')->nullable();
            $table->string('description')->nullable();
            $table->string('content', 2000)->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->boolean('paid')->default(false);
            // $table->date('paymentDate'); 
            $table->string('type');
            $table->date('cycleDate')->nullable();
            $table->Integer('cycleFrequency')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('contractor_id')->nullable();
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
