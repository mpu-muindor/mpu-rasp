<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons',
            function (Blueprint $table) {
                $table->id();
                $table->string('subject');
                $table->date('date_from')->nullable()->default(null)->comment('Пустое, если пара не регулярная');
                $table->date('date_to')->nullable()->default(null)->comment('Пустое, если пара не регулярная');;
                $table->string('type')->default('NaN');
                $table->unsignedInteger('day_number')->comment('Номер дня недели');
                $table->unsignedInteger('lesson_number')->comment('Номер пары');
                $table->date('lesson_day')->nullable()->default(null)->comment('Дата пары, если не регулярная');
                $table->boolean('is_session')->default(false)->comment('True, если пара не регулярная');
                $table->string('remote_access', 300)->nullable()->comment('Если есть ссылка на вебинар');
                $table->unsignedBigInteger('group_id');
                $table->timestamps();

                $table->foreign('group_id')->references('id')->on('groups');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
