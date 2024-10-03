<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role_id dan menetapkannya sebagai foreign key
            $table->unsignedBigInteger('role_id')->nullable()->after('password');

            // Menambahkan foreign key yang mengacu ke kolom id di tabel roles
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus foreign key dan kolom role_id jika rollback
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
