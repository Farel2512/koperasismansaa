<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBelanjasTable extends Migration
{
    public function up()
    {
        Schema::create('data_belanjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('belanja_id')->constrained('belanjas')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('harga_total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_belanjas');
    }
}
