// database/migrations/xxxx_xx_xx_xxxxxx_add_type_to_products_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->string('type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->dropColumn('type');
        });
    }
}
