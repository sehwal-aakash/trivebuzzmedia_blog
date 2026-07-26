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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('color', 30)->nullable()->default('#3c83f6')->after('description');
            $table->string('icon', 50)->nullable()->default('📂')->after('color');
            $table->boolean('is_featured')->default(false)->after('icon');
            $table->integer('sort_order')->default(0)->after('is_featured');
            $table->string('meta_title')->nullable()->after('sort_order');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'color',
                'icon',
                'is_featured',
                'sort_order',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ]);
        });
    }
};
