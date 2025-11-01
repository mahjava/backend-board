<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable()->change();
            $table->unsignedBigInteger('assignee_id')->nullable()->change();
            $table->unsignedBigInteger('status_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable(false)->change();
            $table->unsignedBigInteger('assignee_id')->nullable(false)->change();
            $table->unsignedBigInteger('status_id')->nullable(false)->change();
        });
    }
};
