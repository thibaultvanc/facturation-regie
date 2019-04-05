<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreatePointagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //dd(__METHOD__.':'.__LINE__, '__ H E R E ddddddddddddddddddddddddddddd__');
        Schema::create('pointages', function (Blueprint $table) {
            $userForeignKey = config('facturation-regie .users_table_foreign_key', 'user_id');

            
            $table->increments('id');
            $table->dateTime('date');
            
            $table->boolean('is_facturable')->default(0);

            
            $table->string('name');
            $table->text('description');

            $table->unsignedInteger($userForeignKey);
            $table->unsignedInteger('pointable_id');
            $table->string('pointable_type')->index();

            $table->timestamps();

            $table->foreign($userForeignKey)
                ->references(config('facturation-regie.users_table_primary_key', 'id'))
                ->on(config('facturation-regie.users_table_name', 'users'))
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pointages');
    }
}
