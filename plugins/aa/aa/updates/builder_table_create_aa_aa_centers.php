<?php namespace Aa\Aa\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateAaAaCenters extends Migration
{
    public function up()
    {
        // First, create the table
        Schema::create('aa_aa_centers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->nullable()->unsigned();
            $table->timestamps(); // This creates created_at and updated_at
        });

        // Then add the foreign key constraint
        Schema::table('aa_aa_centers', function ($table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('aa_aa_centers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        // Drop the foreign key constraint first
        Schema::table('aa_aa_centers', function ($table) {
            $table->dropForeign(['parent_id']);
        });
        
        Schema::dropIfExists('aa_aa_centers');
    }
}