<?php

use App\Models\Copy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copies', function (Blueprint $table) {
            $table->id('copy_id');
            //melyik könyv példánya
            $table->foreignId('book_id')->references('book_id')->on('books');
            //kemény: 1 vagy puha kötésű: 0; tinyInteger ugyanaz
            $table->boolean('hardcovered')->default(0);
            $table->year('publication')->default(2000);
            //alapból a könyvtárban (0), ki van adva: 1, selejtre ítélve: 2
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Copy::create(['book_id'=>2, 'publication' =>1996, 'status'=>1]);
        Copy::create(['book_id'=>3, 'status'=>1]);
        Copy::create(['book_id'=>3]);
        Copy::create(['book_id'=>3, 'hardcovered'=> 1]);
        Copy::create(['book_id'=>3, 'status'=>2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copies');
    }
};
