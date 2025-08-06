<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_task_survey_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('task_id');
            $table->string('id_pertanyaan');
            $table->string('tipe_pertanyaan');
            $table->text('jawaban')->nullable();
            $table->timestamps();

            // FK Constraint
            $table->foreign('task_id')
                ->references('TaskID')
                ->on('t_task_survey')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_task_survey_details');
    }
};
