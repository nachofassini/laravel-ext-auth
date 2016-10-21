<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 20);
            $table->string('nombre', 150);
            $table->string('descripcion', 300);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table)
        {
            $table->integer('estado_id')->unsigned()->nullable();
            $table->foreign('estado_id')->references('id')->on('users_estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropForeign('users_estado_id_foreign');
            $table->dropColumn('estado_id');
        });

        Schema::drop('users_estados');
    }

}
