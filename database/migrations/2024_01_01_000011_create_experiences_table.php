<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('role_en')->nullable();
            $table->string('company');
            $table->string('company_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('year_from')->nullable();
            $table->integer('year_to')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('technologies')->nullable(); // comma separated
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('experiences'); }
};
