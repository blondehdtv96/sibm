@php($isEdit = isset($staffProfile))

<form action="{{ $isEdit ? route('admin.staff-profiles.update', $staffProfile) : route('admin.staff-profiles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="font-semibold text-red-700">Gagal menyimpan. Periksa kembali data berikut:</p>
            <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Identitas & Jabatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2"><label for="name" class="field-label">Nama Lengkap *</label><input id="name" name="name" required value="{{ old('name', $staffProfile->name ?? '') }}" class="field-input">@error('name')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="gelar_depan" class="field-label">Gelar Depan</label><input id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan', $staffProfile->gelar_depan ?? '') }}" placeholder="Dr., Ir." class="field-input"></div>
                    <div><label for="gelar_belakang" class="field-label">Gelar Belakang</label><input id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang', $staffProfile->gelar_belakang ?? '') }}" placeholder="S.Pd., M.Kom." class="field-input"></div>
                    <div><label for="nip" class="field-label">NIP</label><input id="nip" name="nip" value="{{ old('nip', $staffProfile->nip ?? '') }}" class="field-input"></div>
                    <div><label for="nuptk" class="field-label">NUPTK</label><input id="nuptk" name="nuptk" value="{{ old('nuptk', $staffProfile->nuptk ?? '') }}" class="field-input"></div>
                    <div><label for="position" class="field-label">Jabatan *</label><input id="position" name="position" required value="{{ old('position', $staffProfile->position ?? '') }}" placeholder="Guru Matematika / Kepala TU" class="field-input">@error('position')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="category" class="field-label">Kategori *</label><select id="category" name="category" required class="field-input">@foreach($categories as $category)<option value="{{ $category }}" {{ old('category', $staffProfile->category ?? 'Guru') === $category ? 'selected' : '' }}>{{ $category }}</option>@endforeach</select></div>
                    <div><label for="employment_status" class="field-label">Status Kepegawaian</label><select id="employment_status" name="employment_status" class="field-input"><option value="">Pilih status</option>@foreach($employmentStatuses as $item)<option value="{{ $item }}" {{ old('employment_status', $staffProfile->employment_status ?? '') === $item ? 'selected' : '' }}>{{ $item }}</option>@endforeach</select></div>
                    <div><label for="jurusan" class="field-label">Jurusan / Program Keahlian</label><input id="jurusan" name="jurusan" value="{{ old('jurusan', $staffProfile->jurusan ?? '') }}" placeholder="TKJ / TKR / DKV" class="field-input"></div>
                    <div class="md:col-span-2"><label for="subjects" class="field-label">Mata Pelajaran yang Diampu</label><input id="subjects" name="subjects" value="{{ old('subjects', $staffProfile->subjects ?? '') }}" placeholder="Pemrograman Web, Jaringan Dasar" class="field-input"></div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Biodata</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div><label for="birth_place" class="field-label">Tempat Lahir</label><input id="birth_place" name="birth_place" value="{{ old('birth_place', $staffProfile->birth_place ?? '') }}" class="field-input"></div>
                    <div><label for="birth_date" class="field-label">Tanggal Lahir</label><input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', isset($staffProfile) && $staffProfile->birth_date ? $staffProfile->birth_date->format('Y-m-d') : '') }}" class="field-input"></div>
                    <div><label for="gender" class="field-label">Jenis Kelamin</label><select id="gender" name="gender" class="field-input"><option value="">Pilih</option><option value="Laki-laki" {{ old('gender', $staffProfile->gender ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('gender', $staffProfile->gender ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div>
                    <div><label for="religion" class="field-label">Agama</label><input id="religion" name="religion" value="{{ old('religion', $staffProfile->religion ?? '') }}" class="field-input"></div>
                    <div><label for="email" class="field-label">Email</label><input id="email" name="email" type="email" value="{{ old('email', $staffProfile->email ?? '') }}" class="field-input"></div>
                    <div><label for="phone" class="field-label">Nomor HP</label><input id="phone" name="phone" value="{{ old('phone', $staffProfile->phone ?? '') }}" class="field-input"></div>
                    <div class="md:col-span-2"><label for="address" class="field-label">Alamat</label><textarea id="address" name="address" rows="3" class="field-input">{{ old('address', $staffProfile->address ?? '') }}</textarea></div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Pendidikan, Sertifikasi & Kompetensi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div><label for="education" class="field-label">Pendidikan Terakhir</label><input id="education" name="education" value="{{ old('education', $staffProfile->education ?? '') }}" placeholder="S1 Pendidikan Teknik Informatika" class="field-input"></div>
                    <div><label for="motto" class="field-label">Motto Mengajar</label><input id="motto" name="motto" value="{{ old('motto', $staffProfile->motto ?? '') }}" class="field-input"></div>
                    @foreach([['education_history','Riwayat Pendidikan'], ['certifications','Sertifikasi'], ['competencies','Bidang Keahlian'], ['experience','Pengalaman Mengajar'], ['achievements','Prestasi']] as [$field, $label])
                        <div class="md:col-span-2"><label for="{{ $field }}" class="field-label">{{ $label }}</label><textarea id="{{ $field }}" name="{{ $field }}" rows="4" class="field-input" placeholder="Satu item per baris">{{ old($field, $staffProfile->{$field} ?? '') }}</textarea></div>
                    @endforeach
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Sosial Media</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach([['facebook','Facebook'], ['instagram','Instagram'], ['linkedin','LinkedIn'], ['youtube','YouTube'], ['website','Website Pribadi']] as [$field, $label])
                        <div><label for="{{ $field }}" class="field-label">{{ $label }}</label><input id="{{ $field }}" name="{{ $field }}" type="url" value="{{ old($field, $staffProfile->{$field} ?? '') }}" placeholder="https://" class="field-input">@error($field)<p class="field-error">{{ $message }}</p>@enderror</div>
                    @endforeach
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Galeri Kegiatan</h3>
                <p class="text-sm text-gray-500 mb-4">Upload beberapa foto kegiatan, seminar, workshop, atau pelatihan.</p>
                <input type="file" name="gallery_images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full px-3 py-3 border border-dashed border-gray-300 rounded-xl">
                <p class="mt-2 text-xs text-gray-500">Maksimal 10 MB per foto.</p>
                @if($isEdit && $staffProfile->images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        @foreach($staffProfile->images as $image)
                            <div class="relative group"><img src="{{ $image->thumbnail_url }}" alt="{{ $image->caption }}" class="aspect-square w-full object-cover rounded-lg"><button type="submit" form="delete-image-{{ $image->id }}" class="absolute top-2 right-2 hidden group-hover:block rounded-full bg-red-600 text-white w-7 h-7">×</button></div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <aside class="space-y-6">
            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Foto Profil</h3>
                @if($isEdit && $staffProfile->photo)<img src="{{ $staffProfile->photo_url }}" alt="{{ $staffProfile->display_name }}" class="w-40 h-40 rounded-2xl object-cover mx-auto mb-4">@endif
                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-2 text-xs text-gray-500">JPG, PNG, GIF, WEBP. Maksimal 10 MB.</p>
                @error('photo')<p class="field-error">{{ $message }}</p>@enderror
            </section>
            <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5">
                <h3 class="text-lg font-bold text-gray-900">Publikasi</h3>
                <div><label for="status" class="field-label">Status *</label><select id="status" name="status" required class="field-input"><option value="active" {{ old('status', $staffProfile->status ?? 'active') === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('status', $staffProfile->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option></select></div>
                <label class="flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $staffProfile->is_featured ?? false) ? 'checked' : '' }} class="rounded text-blue-700"> Tampilkan sebagai profil unggulan</label>
                <div><label for="sort_order" class="field-label">Urutan</label><input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $staffProfile->sort_order ?? '') }}" class="field-input"></div>
            </section>
            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-[#1E3A8A] text-white font-bold hover:bg-blue-900 transition">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Profil' }}</button>
            <a href="{{ route('admin.staff-profiles.index') }}" class="block w-full px-4 py-3 text-center rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200">Batal</a>
        </aside>
    </div>
</form>

@if($isEdit && $staffProfile->images->count() > 0)
    @foreach($staffProfile->images as $image)
        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.staff-profiles.images.destroy', [$staffProfile, $image]) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
    @endforeach
@endif

@once
<style>
.field-label{display:block;font-size:.875rem;font-weight:600;color:#374151;margin-bottom:.5rem}.field-input{width:100%;padding:.65rem .85rem;border:1px solid #d1d5db;border-radius:.65rem;background:#fff}.field-input:focus{outline:0;border-color:#1e3a8a;box-shadow:0 0 0 3px rgba(30,58,138,.12)}.field-error{margin-top:.25rem;font-size:.75rem;color:#dc2626}
</style>
@endonce
