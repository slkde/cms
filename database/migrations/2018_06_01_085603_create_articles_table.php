<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artisans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->comment('分类ID');
            $table->integer('district_id')->comment('地区ID');
            $table->string('linkman',11)->comment('称呼');
            $table->string('tel',11)->comment('电话号码');
            $table->string('email',50)->nullable()->comment('邮箱地址');
            $table->string('weichat',50)->nullable()->comment('微信地址');
            $table->string('title',32)->comment('标题');
            $table->text('content')->comment('内容');
            $table->timestamp('expired_days')->comment('过期时间');
            $table->integer('hits')->default(1)->comment('查看次数');
            $table->string('manage_passwd',32)->comment('管理密码');
            $table->ipAddress('ip')->comment('IP地址');
            $table->enum('is_mobile', ['NOT', 'YES'])->default('NOT');
            $table->enum('is_verify', ['NOT', 'YES'])->default('NOT');
            $table->enum('is_top', ['NOT', 'cate', 'index'])->default('NOT');
            $table->timestamp('category_top_expired')->nullable();
            $table->timestamp('index_top_expired')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artisans');
    }
}
