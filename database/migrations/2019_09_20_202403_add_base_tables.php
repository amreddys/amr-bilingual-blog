<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('category_owner')->unsigned()->nullable();
            $table->integer('post_limit')->default(0);
            $table->string('limit_type',20)->nullable();
            $table->boolean('can_delete')->default(1);
            $table->foreign('category_owner')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();

            $table->string('title_en');
            $table->longText('content_en');
            $table->string('excerpt_en')->nullable();

            $table->string('title_tel');
            $table->longText('content_tel');
            $table->string('excerpt_tel')->nullable();

            $table->string('featured_image');
            $table->string('slug',20)->unique();
            $table->string('status',20);
            $table->boolean('comments_enabled')->default(1);
            $table->index('status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('posts_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
