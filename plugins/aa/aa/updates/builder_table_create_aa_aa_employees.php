<?php namespace Aa\Aa\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateAaAaEmployees extends Migration
{
    public function up()
    {
        Schema::create('aa_aa_employees', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string('full_name');
            $table->string('name');
            $table->string('father_name');
            $table->string('last_name')->nullable();
            $table->string('mother_name');
            $table->string('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('status')->nullable();
            $table->string('national_id');
            $table->string('rank');
            $table->integer('center_id')->nullable()->unsigned();
            $table->date('date_of_enrollment')->nullable();
            $table->integer('salare_id')->nullable()->unsigned();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->text('notes')->nullable();


            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('center_id')
                    ->references('id')
                    ->on('aa_aa_centers')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('salare_id')
                    ->references('id')
                    ->on('aa_aa_salares')
                    ->onDelete('cascade')->onUpdate('cascade');
                    });
    }
    
    public function down()
    {
        Schema::dropIfExists('aa_aa_employees');
    }
}
