<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('nip')->nullable()->after('name');
            $table->string('nuptk')->nullable()->after('nip');
            $table->string('gelar_depan')->nullable()->after('name');
            $table->string('gelar_belakang')->nullable()->after('nuptk');
            $table->string('gender', 30)->nullable()->after('gelar_belakang');
            $table->string('religion', 50)->nullable()->after('gender');
            $table->string('birth_place')->nullable()->after('religion');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->string('jurusan')->nullable()->after('category');
            $table->string('subjects')->nullable()->after('jurusan');
            $table->string('employment_status')->nullable()->after('subjects');
            $table->string('email')->nullable()->after('bio');
            $table->string('phone', 30)->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('education')->nullable()->after('address');
            $table->text('education_history')->nullable()->after('education');
            $table->text('certifications')->nullable()->after('education_history');
            $table->text('competencies')->nullable()->after('certifications');
            $table->text('experience')->nullable()->after('competencies');
            $table->text('achievements')->nullable()->after('experience');
            $table->text('motto')->nullable()->after('achievements');
            $table->string('facebook')->nullable()->after('motto');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('linkedin')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('linkedin');
            $table->string('website')->nullable()->after('youtube');
            $table->boolean('is_featured')->default(false)->after('status');
            $table->softDeletes();

            $table->index('nip');
            $table->index('nuptk');
            $table->index('jurusan');
            $table->index('subjects');
            $table->index('employment_status');
        });
    }

    public function down(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropUnique(['slug']);
            $table->dropIndex(['nip']);
            $table->dropIndex(['nuptk']);
            $table->dropIndex(['jurusan']);
            $table->dropIndex(['subjects']);
            $table->dropIndex(['employment_status']);
            $table->dropColumn([
                'slug', 'nip', 'nuptk', 'gelar_depan', 'gelar_belakang', 'gender', 'religion',
                'birth_place', 'birth_date', 'jurusan', 'subjects', 'employment_status', 'email',
                'phone', 'address', 'education', 'education_history', 'certifications',
                'competencies', 'experience', 'achievements', 'motto', 'facebook', 'instagram',
                'linkedin', 'youtube', 'website', 'is_featured',
            ]);
        });
    }
};
