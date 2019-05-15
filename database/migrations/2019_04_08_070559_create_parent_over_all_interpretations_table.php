<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentOverAllInterpretationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_over_all_interpretations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_ids')->nullable();
            $table->string('individual_range_ids')->nullable();
            $table->string('overall_range')->nullable();
            $table->text('interpretation')->nullable();
            /*$table->text('summary')->nullable();*/
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
    public function down()
    {
        Schema::dropIfExists('parent_over_all_interpretations');
    }
}
