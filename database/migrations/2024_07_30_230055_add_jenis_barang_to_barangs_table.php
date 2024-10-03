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
    Schema::table('barangs', function (Blueprint $table) {
        $table->enum('jenis_barang', ['Jasa', 'ATK', 'Snack', 'Minuman'])->after('nama');
    });
}

public function down()
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropColumn('jenis_barang');
    });
}

};
