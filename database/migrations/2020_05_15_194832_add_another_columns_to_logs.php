<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherColumnsToLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->unsignedBigInteger('digest_type_id')->nullable()->after('status');
            $table->unsignedBigInteger('contact_id')->nullable()->after('status');
            $table->unsignedBigInteger('subscription_id')->nullable()->after('status');
            //$table->dropColumn(['digest_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['digest_type_id','contact_id']);
        });
    }
}
