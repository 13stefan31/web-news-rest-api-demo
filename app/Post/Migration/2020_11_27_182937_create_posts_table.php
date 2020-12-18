<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
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
            $table->text('header_main');
            $table->text('subheader');
            $table->integer('category')->unsigned()->nullable();
            $table->longText('posts_content')->nullable();
            $table->longText('picture_links')->nullable();
            $table->integer('owner')->unsigned()->nullable();
            $table->boolean('recommended')->default(False);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->boolean('is_active')->default(False);
            $table->foreign('owner')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category')->references('id')->on('categories')->onDelete('set null');
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
