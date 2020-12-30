<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // 記事
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // カテゴリID
            $table->integer('blog_category_id')->index();                        
            // タイトル
            $table->string('title')->unique();
            // キーワード
            $table->string('keywords');
            // 説明
            $table->string('description');            
            // 本文
            $table->text('body');
            
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
        Schema::dropIfExists('blog_articles');
    }
}
