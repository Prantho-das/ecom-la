<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationLinksTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('navigation_menu_id')->constrained()->onDelete('cascade');

            $table->string('type'); // 'category', 'brand', 'page', 'custom'

            $table->unsignedBigInteger('reference_id')->nullable(); // FK to category/brand/page id (nullable for custom)

            $table->string('label')->nullable(); // override label or custom text

            $table->string('custom_url')->nullable(); // only used if type == 'custom'

            $table->integer('sort_order')->default(0);

            $table->timestamps();

            // Optional indexes for faster lookup
            $table->index(['navigation_menu_id', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_links');
    }
}
