<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_services', function (Blueprint $table) {
            $table->id();
            $table-> string('name');
            $table-> string('description');
            $table-> double('price', 6, 2);
            $table->foreignIdFor(\App\Models\Company::class, 'company_id');
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
        Schema::dropIfExists('business_services');
    }
};
