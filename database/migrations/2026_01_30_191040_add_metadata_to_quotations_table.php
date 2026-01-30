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
        Schema::table('quotations', function (Blueprint $table) {
            $table->text('customer_address')->nullable()->after('customer_email');
            $table->string('customer_phone')->nullable()->after('customer_address');
            $table->string('customer_fax')->nullable()->after('customer_phone');
            $table->string('attn')->nullable()->after('customer_fax');
            $table->string('payment_term')->nullable()->after('attn');
            $table->string('customer_po')->nullable()->after('payment_term');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'customer_address',
                'customer_phone',
                'customer_fax',
                'attn',
                'payment_term',
                'customer_po',
            ]);
        });
    }
};
