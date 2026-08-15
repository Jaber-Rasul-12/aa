<?php namespace Aa\Aa\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateAaAaPayrolls extends Migration
{
    public function up()
    {
        Schema::create('aa_aa_payrolls', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('salare_id')->unsigned();
            $table->integer('year_id')->unsigned();
            $table->integer('month_id')->unsigned();
            $table->double('discount', 10, 0);
            $table->double('price', 10, 0);

            $table->boolean('status');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('employee_id')
                    ->references('id')
                    ->on('aa_aa_employees')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('salare_id')
                    ->references('id')
                    ->on('aa_aa_salares')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('year_id')
                    ->references('id')
                    ->on('aa_aa_years')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('month_id')
                    ->references('id')
                    ->on('aa_aa_months')
                    ->onDelete('cascade')->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('aa_aa_payrolls');
    }
}
