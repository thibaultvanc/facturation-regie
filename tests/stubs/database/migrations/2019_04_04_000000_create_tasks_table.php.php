<?php
/*
 * This file is part of the overtrue/laravel-follow
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('responsable_id')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('tasks');
    }
}
