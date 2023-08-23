<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TicketStatusEnum;
use App\Enums\ApproveStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->text('link');
            $table->timestamp('start_day')->nullable();
            $table->timestamp('end_day')->nullable();
            $table->integer('proposed_completion_day')->unsigned()->default(0);
            $table->enum('status', [
                TicketStatusEnum::PENDING->value,
                TicketStatusEnum::IN_PROGRESS->value,
                TicketStatusEnum::COMPLETED->value,
                TicketStatusEnum::QA_PASSED->value,
                TicketStatusEnum::PROD_READY->value,
                TicketStatusEnum::IN_PROD->value,
            ])->default(TicketStatusEnum::PENDING->value);
            $table->unsignedBigInteger('user_id')->comment('Verified By');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();
            $table->enum('verify_status', [
                ApproveStatusEnum::APPROVED->value,
                ApproveStatusEnum::NOT_APPROVED->value,
            ])->default(ApproveStatusEnum::NOT_APPROVED->value);
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
        Schema::dropIfExists('tickets');
    }
};
