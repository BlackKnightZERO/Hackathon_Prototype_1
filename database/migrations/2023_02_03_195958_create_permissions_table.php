<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PermissionEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->enum('title', [
                PermissionEnum::INDEX->value,
                PermissionEnum::VIEW->value,
                PermissionEnum::CREATE->value,
                PermissionEnum::UPDATE->value,
                PermissionEnum::DELETE->value,
            ])->default(PermissionEnum::VIEW->value);
            $table->foreign('module_id')
                    ->references('id')
                    ->on('modules')
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
        Schema::dropIfExists('permissions');
    }
};
