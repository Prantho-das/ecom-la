<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->cascadeOnDelete();
            $table->string('name', 191);
            $table->char('swatch_color', 7)->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->unique(['option_id', 'name'], 'uk_option_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_values');
    }
};
