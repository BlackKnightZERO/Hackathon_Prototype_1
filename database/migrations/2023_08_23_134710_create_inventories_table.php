<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\InventoryTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', [
                InventoryTypeEnum::COMPUTER->value,
                InventoryTypeEnum::LAPTOP->value,
                InventoryTypeEnum::MOUSE->value,
                InventoryTypeEnum::KEYBOARD->value,
                InventoryTypeEnum::MONITOR->value,
                InventoryTypeEnum::HEADPHONE->value,
                InventoryTypeEnum::SERVER->value,
                InventoryTypeEnum::PRINTER->value,
                InventoryTypeEnum::NETWORKING_EQUIPMENT->value,
                InventoryTypeEnum::SECURITY_EQUIPMENT->value,
                InventoryTypeEnum::STORAGE_DEVICE->value,
                InventoryTypeEnum::OTHER->value,
            ])->default(InventoryTypeEnum::OTHER->value);
            $table->string('manufacturer');
            $table->string('model');
            $table->string('serial_number');
            $table->unsignedBigInteger('user_id')->comment('Assigned To');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('inventories');
    }
};
