<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addIndexingToMtppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('fmt_mtpp_ques')) {
            Schema::table('fmt_mtpp_ques', function (Blueprint $table) {
                $table->index('active');
                $table->index('media_id');
            });
        }
        if (Schema::hasTable('fmt_mtpp_pic')) {
            Schema::table('fmt_mtpp_pic', function (Blueprint $table) {
                $table->index('question_id');
                $table->index('active');
                $table->index('media_id');
            });
        }
        if (Schema::hasTable('fmt_mtpp_text')) {
            Schema::table('fmt_mtpp_text', function (Blueprint $table) {
                $table->index('pic_id');
                $table->index('ques_id');
                $table->index('active');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('fmt_mtpp_pic');
    }
}
