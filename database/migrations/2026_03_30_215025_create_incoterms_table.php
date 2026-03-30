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
        Schema::create('incoterms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_export_freight')->default(false);
            $table->boolean('has_export_clearance')->default(false);
            $table->boolean('has_origin_thc')->default(false);
            $table->boolean('has_int_freight')->default(false);
            $table->boolean('has_insurance')->default(false);
            $table->boolean('has_import_duties')->default(false);
            $table->boolean('has_handling_charges')->default(false);
            $table->boolean('has_inland_transport')->default(false);
            $table->json('currency_defaults')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoterms');
    }
};
