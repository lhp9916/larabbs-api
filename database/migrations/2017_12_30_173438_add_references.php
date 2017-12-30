<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * 利用外键约束，防止数据损坏
     *
     * 删除用户时，删掉其话题和回复
     * 删除话题时，删掉其回复
     */


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('replies', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('replies', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropForeign(['topic_id']);

        });
    }
}
