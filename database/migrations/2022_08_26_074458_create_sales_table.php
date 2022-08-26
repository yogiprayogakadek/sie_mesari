<?php

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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->char('transaction_code', 10);
            $table->foreignId('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->references('id')->on('members');
            $table->integer('discount')->nullable();
            $table->integer('total');
            $table->date('sale_date');
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
        Schema::dropIfExists('sales');
    }
};
