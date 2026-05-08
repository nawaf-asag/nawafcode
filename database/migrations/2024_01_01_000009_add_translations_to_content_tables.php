<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->string('contribution_en')->nullable()->after('contribution');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en']);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en']);
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['contribution_en']);
        });
    }
};
