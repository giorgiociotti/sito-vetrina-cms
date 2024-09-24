<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAdminToUsersTable extends Migration
{
    /**
     * Esegui le modifiche alla tabella `users`.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Aggiungi il campo 'is_admin' come booleano con valore predefinito 'false'
            $table->boolean('is_admin')->default(false)->after('email'); // 'after' è opzionale, ma posiziona il campo dopo 'email'
        });
    }

    /**
     * Ripristina le modifiche alla tabella `users`.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rimuovi il campo 'is_admin' se esiste
            $table->dropColumn('is_admin');
        });
    }
}
