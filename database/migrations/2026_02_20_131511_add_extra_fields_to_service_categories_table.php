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
        Schema::table('service_categories', function (Blueprint $table) {
            $table->text('full_description')->nullable()->after('short_description');
            $table->string('feature_image')->nullable()->after('image');
            $table->string('benefit_image')->nullable()->after('feature_image');
            $table->json('links')->nullable()->after('benefit_image');
            $table->json('industries')->nullable()->after('links');
            $table->json('features')->nullable()->after('industries');
            $table->json('benefits')->nullable()->after('features');
            $table->json('related_services')->nullable()->after('benefits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->dropColumn([
                'full_description',
                'feature_image',
                'benefit_image',
                'links',
                'industries',
                'features',
                'benefits',
                'related_services',
            ]);
        });
    }
};
