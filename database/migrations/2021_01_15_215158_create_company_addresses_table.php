<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->string('province');
            $table->string('district');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('building_number');
            $table->string('door_number');
            $table->decimal('latitude', 16, 14);
            $table->decimal('longitude', 17, 14);
            $table->timestamps();

            $table->index(['company_id', 'province', 'district']);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_addresses');
    }
}
