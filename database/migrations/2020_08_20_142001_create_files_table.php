<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id');

            $table->string('dbx_id');
            $table->string('name');
            $table->string('root');
            $table->string('path');
            $table->bigInteger('size')->nullable();
            $table->dateTimeTz('last_modified')->nullable();
            $table->enum('type', ['file', 'folder']);

            $table->enum('status', ['created', 'edited', 'deleted'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
