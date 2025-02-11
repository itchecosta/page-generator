<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('page_sets', function (Blueprint $table) {
            $table->string('csv_file')->nullable()->after('meta_keywords');
        });
    }

    public function down()
    {
        Schema::table('page_sets', function (Blueprint $table) {
            $table->dropColumn('csv_file');
        });
    }
};
