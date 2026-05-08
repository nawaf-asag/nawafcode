<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('path');                 // e.g. "media/abc123.jpg" inside public disk
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('size')->nullable(); // bytes
            $table->string('alt')->nullable();
            $table->timestamps();
            $table->index('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
