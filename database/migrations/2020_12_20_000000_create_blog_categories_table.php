<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // カテゴリ
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // 名前
            $table->string('name')->unique();
            // 説明
            $table->text('description');
            // 表示順序
            $table->integer('sort');
            
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
        Schema::dropIfExists('blog_categories');
    }
}
