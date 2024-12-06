<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackendMainCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect(['tw_', 'en_'])->map(function($locale){
            Schema::create( $locale . 'backend_main_categories', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('title');
                $table->string('subtitle');
                $table->string('img');
                $table->text('content');
                
                //通用欄位
                
                $table->boolean('fantasy_hide')->default(false)->comment('後台隱藏不顯示');
                $table->integer('w_rank')->default(12)->comment('排序');
                $table->boolean('is_reviewed')->default(false)->comment('審核');
                $table->boolean('is_preview')->default(false)->comment('預覽');
                $table->boolean('is_visible')->default(false)->comment('前台是否顯示');
                $table->boolean('wait_del')->default(false)->comment('申請刪除');
                
                $table->string('temp_url')->comment('預設網址名稱');
                $table->string('url_name')->comment('網址名稱');
    
                $table->integer('branch_id')->default(1)->comment('分館ID');
                $table->integer('create_id')->comment('Fantasy User ID');

                $table->timestamps();
            });
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        collect(['tw_', 'en_'])->map(function($locale){
            Schema::dropIfExists( $locale . 'backend_main_categories');
        });

    }
}
