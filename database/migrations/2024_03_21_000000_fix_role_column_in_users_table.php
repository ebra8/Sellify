<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, ensure the role column exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });
        }

        // Update existing users to have proper roles
        DB::table('users')->whereNull('role')->orWhere('role', '')->update(['role' => 'user']);
        
        // Convert is_admin to role if needed
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::table('users')->where('is_admin', true)->update(['role' => 'admin']);
        }
    }

    public function down()
    {
        // No need to revert the role column as it's a core feature
    }
}; 