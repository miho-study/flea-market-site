<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFactorColumnsToUsersTable extends Migration
{
	public function up(): void
	{
		// Two-factor authentication is disabled; keep this migration as a no-op.
	}

	public function down(): void
	{
		// No-op.
	}
}
