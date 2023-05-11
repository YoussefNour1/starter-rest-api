<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("company_name", 255)->unique();
            $table->string('company_industry');
            $table->string("company_address", 255);
            $table->string("company_location", 255);
            $table->enum('company_size', ['Micro', 'Small', 'Mini', 'Large']);
            $table->string('logo')->nullable();
            $table->string('logo_path')->nullable()->after('logo');
            $table->foreignIdFor(User::class, "user_id")->nullable();
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
        Schema::dropIfExists('companies');
    }
};
