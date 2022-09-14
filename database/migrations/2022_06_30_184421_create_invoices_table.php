<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();
            $table->string('invoice_number', 50);
            $table->date('invoice_Date')->nullable();
            $table->date('Due_date')->nullable();
            $table->string('product');
            $table->unsignedBigInteger( 'section_id' );
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('Amount_collection',8,2);
            $table->decimal('Amount_Commission',8,2);
            $table->decimal('Discount',8,2);
            $table->decimal('Value_VAT',8,2);
            $table->string('Rate_VAT', 999);
            $table->decimal('Total',9,2);
            $table->string('Status', 50); // paid , not paid , partial paid
            $table->integer('Value_Status'); // 1 paid , 2 not paid  , 3 partial paid
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable(); // invoice paid date
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
