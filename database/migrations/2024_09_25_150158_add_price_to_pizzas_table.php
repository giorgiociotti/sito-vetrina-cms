<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToPizzasTable extends Migration
{
    /**
     * Esegui la migration per aggiungere il campo 'price'.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('name')->nullable(); // Aggiunge il campo 'price'
        });
    }

    /**
     * Ripristina la migration rimuovendo il campo 'price'.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->dropColumn('price'); // Rimuove il campo 'price'
        });
    }
}
