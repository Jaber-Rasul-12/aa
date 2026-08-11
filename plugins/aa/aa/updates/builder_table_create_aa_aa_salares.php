<?php namespace Aa\Aa\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateAaAaSalares extends Migration
{
    public function up()
    {
        Schema::create('aa_aa_salares', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('currency');
            $table->double('price', 10, 0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('aa_aa_salares');
    }
}
