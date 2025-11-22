<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationMenusTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Header, Footer
            $table->string('slug')->unique(); // e.g. header, footer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_menus');
    }
}
