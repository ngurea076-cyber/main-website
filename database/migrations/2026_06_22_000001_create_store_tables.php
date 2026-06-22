<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('attendant')->after('password');
            $table->boolean('is_active')->default(true)->after('role');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique();
            $table->string('image')->nullable(); $table->unsignedInteger('priority')->default(0); $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id(); $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title'); $table->string('slug')->unique(); $table->string('brand')->nullable();
            $table->text('description')->nullable(); $table->decimal('price', 12, 2)->default(0);
            $table->decimal('old_price', 12, 2)->nullable(); $table->string('stock_status')->default('in_stock');
            $table->json('images')->nullable(); $table->json('specs')->nullable(); $table->boolean('featured')->default(false);
            $table->unsignedInteger('priority')->default(0); $table->timestamps();
            $table->index(['category_id', 'featured']);
        });
        Schema::create('product_catalogue', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name'); $table->string('item')->nullable(); $table->json('specs')->nullable(); $table->timestamps();
        });
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name'); $table->string('phone'); $table->string('email')->nullable();
            $table->text('message')->nullable(); $table->string('status')->default('pending'); $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); $table->string('reference')->unique(); $table->string('customer_name');
            $table->string('phone'); $table->string('email')->nullable(); $table->json('items');
            $table->decimal('total', 12, 2); $table->string('status')->default('pending'); $table->timestamps();
        });
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary(); $table->json('value')->nullable(); $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings'); Schema::dropIfExists('orders'); Schema::dropIfExists('inquiries');
        Schema::dropIfExists('product_catalogue'); Schema::dropIfExists('products'); Schema::dropIfExists('categories');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn(['role', 'is_active']));
    }
};
