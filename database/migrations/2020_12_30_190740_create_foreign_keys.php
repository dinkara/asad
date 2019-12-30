<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->foreign('user_id', 'password_resets_users_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
       
        });
        Schema::table('profiles', function (Blueprint $table) {
            $table->foreign('user_id', 'profiles_users_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
       
        });
        Schema::table('roles_permissions', function (Blueprint $table) {
            $table->foreign('role_id', 'roles_permissions_roles_fk')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
            $table->foreign('permission_id', 'roles_permissions_permissions_fk')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade');
       
        });
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->foreign('user_id', 'user_sessions_users_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
       
        });
        Schema::table('users_roles', function (Blueprint $table) {
            $table->foreign('user_id', 'users_roles_users_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('role_id', 'users_roles_roles_fk')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
       
        });
        Schema::table('users_social_networks', function (Blueprint $table) {
            $table->foreign('user_id', 'users_social_networks_users_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('social_network_id', 'users_social_networks_social_networks_fk')
                  ->references('id')
                  ->on('social_networks')
                  ->onDelete('cascade');
       
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('password_resets_users_fk');

        });
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign('profiles_users_fk');

        });
        Schema::table('roles_permissions', function (Blueprint $table) {
            $table->dropForeign('roles_permissions_roles_fk');
            $table->dropForeign('roles_permissions_permissions_fk');

        });
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropForeign('user_sessions_users_fk');

        });
        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropForeign('users_roles_users_fk');
            $table->dropForeign('users_roles_roles_fk');

        });
        Schema::table('users_social_networks', function (Blueprint $table) {
            $table->dropForeign('users_social_networks_users_fk');
            $table->dropForeign('users_social_networks_social_networks_fk');

        });

    }
}
