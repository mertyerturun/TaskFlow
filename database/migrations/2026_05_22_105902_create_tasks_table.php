<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Hangi projeye ait?
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Görev kime atandı?
            $table->string('title'); // Görev Başlığı
            $table->text('detail')->nullable(); // Görev Detayı (Hocanın notundaki detail alanı)
            $table->string('image')->nullable(); // Görev Ek Dosyası / Resim yolu
            $table->string('status')->default('Active'); // Active veya Passive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
