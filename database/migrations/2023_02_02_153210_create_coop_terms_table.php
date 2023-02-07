<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CoopTermEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coop_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ministry_id');
            $table->enum('term', [
                CoopTermEnum::FIRST->value,
                CoopTermEnum::SECOND->value,
                CoopTermEnum::THIRD->value,
                CoopTermEnum::FOURTH->value,
                CoopTermEnum::FIFTH->value,
                CoopTermEnum::SIXTH->value,
                CoopTermEnum::SEVENTH->value,
                CoopTermEnum::EIGHTH->value,
            ])->default(CoopTermEnum::FIRST->value);
            $table->timestamp('term_start')->nullable();
            $table->timestamp('term_end')->nullable();
            $table->text('position');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();
            $table->foreign('ministry_id')
                    ->references('id')
                    ->on('ministries')
                    ->cascadeOnDelete();
            $table->string('slug')->unique();
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
        Schema::dropIfExists('coop_terms');
    }
};
