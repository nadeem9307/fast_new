<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverallRangeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('overall_range', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('min_range');
            $table->integer('max_range');
            $table->text('parent_male_avatar')->nullable();
            $table->text('parent_female_avatar')->nullable();
            $table->text('child_male_avatar')->nullable();
            $table->text('child_female_avatar')->nullable();
            $table->text('summary')->nullable();
            $table->enum('status', ['1', '2'])->default('1')->comment('Active->1, Inactive->2');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('overall_range');
    }

}
