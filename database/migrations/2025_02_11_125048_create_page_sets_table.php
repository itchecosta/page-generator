<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('page_sets', function (Blueprint $table) {
            $table->id();
            $table->string('title_template');
            $table->text('content_template');
            $table->dateTime('published_at')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            // Você pode incluir outros campos, como informações sobre o CSV original, se desejar.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_sets');
    }
};
