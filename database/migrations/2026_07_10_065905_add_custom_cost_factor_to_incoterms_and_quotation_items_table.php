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
        Schema::table('incoterms', function (Blueprint $table) {
            $table->boolean('has_custom_cost_factor')->default(false)->after('has_inland_transport');
        });

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->decimal('custom_cost_factor', 16, 6)->default(0)->after('inland_transport');
            $table->decimal('custom_cost_factor_rate', 16, 6)->default(0)->after('inland_transport_global');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoterms', function (Blueprint $table) {
            $table->dropColumn('has_custom_cost_factor');
        });

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn(['custom_cost_factor', 'custom_cost_factor_rate']);
        });
    }
};
