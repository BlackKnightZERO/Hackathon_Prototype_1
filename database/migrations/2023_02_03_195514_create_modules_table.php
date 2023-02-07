<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ModuleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->enum('title', [
                ModuleEnum::DASHBOARD->value,
                ModuleEnum::PROFILE->value,
                ModuleEnum::USER->value,
                ModuleEnum::ROLE->value,
                ModuleEnum::PERMISSION->value,
                ModuleEnum::ROLE_PERMISSION->value,
                ModuleEnum::COOPTERM->value,
                ModuleEnum::MINISTRY->value,
            ])->default(ModuleEnum::DASHBOARD->value);
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
        Schema::dropIfExists('modules');
    }
};
