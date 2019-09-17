<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Discusstion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discusstions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->mediumText('content');
//            $table->unsignedInteger('post_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);
//            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('tag_id')
//                ->references('id')
//                ->on('tags');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discusstions');
    }
}
