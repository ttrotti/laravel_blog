<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->after('body');
            // indexamos esto para que cargue más rápido (no se hace siempre porque el index es un archivo por separado)
            // acá tuvimos que borrar todos los datos de prueba anteriores porque no se puede crear un index con valores null
            // entonces salta error si tratamos de agregar slug, por lo que hay que hacer migrate:rollback o migrate:reset o migrate:refresh y dsp volver a migrar
            // aprender a hacer DATA SEEDING, así se rellena la DB cada vez que la rehacemos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
