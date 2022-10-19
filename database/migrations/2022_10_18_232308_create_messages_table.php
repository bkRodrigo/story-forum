<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('body')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('thread_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['thread_id']);
            });
        }
        Schema::dropIfExists('messages');
    }
};
