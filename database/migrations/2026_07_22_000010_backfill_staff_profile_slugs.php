<?php

use App\Models\StaffProfile;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        StaffProfile::withTrashed()
            ->where(function ($query) {
                $query->whereNull('slug')->orWhere('slug', '');
            })
            ->orderBy('id')
            ->get()
            ->each(function (StaffProfile $profile): void {
                $profile->slug = StaffProfile::generateUniqueSlug($profile->name, $profile->id);
                $profile->saveQuietly();
            });
    }

    public function down(): void
    {
        // Slug backfill is a data repair and should not be reversed.
    }
};
