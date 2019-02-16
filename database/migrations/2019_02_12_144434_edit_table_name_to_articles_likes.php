<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTableNameToArticlesLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles_likes', function (Blueprint $table) {
            $table->string('like_type');
            $table->renameColumn('article_id', 'like_id');
            $table->dropColumn('status');
        });
        
        Schema::rename('articles_likes', 'likes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles_likes', function (Blueprint $table) {
            $table->dropColumn('like_type');
            $table->renameColumn('like_id' , 'article_id');
            $table->boolean('status');
        });
        Schema::rename('likes', 'articles_likes');
    }
}
