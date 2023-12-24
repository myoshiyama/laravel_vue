<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixForeignKeyInReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // ここで外部キー制約を修正する
            $table->dropForeign(['booking_id']);
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // ここで外部キー制約の変更をロールバックする
        });
    }
}