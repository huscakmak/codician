<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('title', ['Mr.', 'Mrs.', 'Ms.', 'Mx.', 'Miss', 'Dr'])->nullable();
            $table->string('email_address')->unique();
            $table->string('phone_number')->unique();
            $table->timestamps();

            $table->index(['company_id', 'email_address', 'phone_number']);
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
        Schema::dropIfExists('company_customers');
    }
}
