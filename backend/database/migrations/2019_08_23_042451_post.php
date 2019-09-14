<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Post extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('content');
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('discusstion_id');
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('discusstion_id')
                ->references('id')
                ->on('discusstions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
}
