<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột status
          
            // Thêm cột image
            $table->string('image')->nullable();
    
            // Thêm cột additional_images
            $table->json('additional_images')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
        
    
            // Xóa cột image
            $table->dropColumn('image');
    
            // Xóa cột additional_images
            $table->dropColumn('additional_images');
        });
    }
    
};
