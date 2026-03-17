# Chatbot Jurusan Update - COMPLETE

## Changes Made
Updated chatbot responses to reflect the correct majors/programs at SMK Bina Mandiri Bekasi.

### Old Majors
- TKJ (Teknik Komputer & Jaringan)
- Akuntansi
- DKV (Desain Komunikasi Visual)

### New Majors
- TKJ (Teknik Komputer & Jaringan)
- TSM (Teknik Sepeda Motor)
- TKR (Teknik Kendaraan Ringan)

## Files Modified

### 1. app/Http/Controllers/ChatbotController.php

#### Default Response
Changed from:
```
🎓 Jurusan (TKJ, Akuntansi, DKV)
```

To:
```
🎓 Jurusan (TKJ, TSM, TKR)
```

#### System Prompt for OpenAI
Changed from:
```
Fokus pada informasi sekolah, jurusan (TKJ, Akuntansi, DKV), PPDB, dan fasilitas.
```

To:
```
Fokus pada informasi sekolah, jurusan (TKJ, TSM, TKR), PPDB, dan fasilitas.
```

#### Program Keahlian Response
Changed from:
```
1. Teknik Komputer & Jaringan (TKJ) 💻
2. Akuntansi 💰
3. Desain Komunikasi Visual (DKV) 🎨
```

To:
```
1. Teknik Komputer & Jaringan (TKJ) 💻
   - Belajar networking, programming, dan sistem komputer
   - Prospek: Network Administrator, IT Support, Web Developer

2. Teknik Sepeda Motor (TSM) 🏍️
   - Belajar perawatan, perbaikan, dan modifikasi sepeda motor
   - Prospek: Mekanik Motor, Teknisi Bengkel, Wirausaha Otomotif

3. Teknik Kendaraan Ringan (TKR) 🚗
   - Belajar perawatan, perbaikan, dan teknologi kendaraan ringan
   - Prospek: Mekanik Mobil, Teknisi Otomotif, Service Advisor
```

#### Keywords Updated
Changed from:
```php
['jurusan', 'program keahlian', 'kompetensi', 'tkj', 'akuntansi', 'dkv']
```

To:
```php
['jurusan', 'program keahlian', 'kompetensi', 'tkj', 'tsm', 'tkr']
```

#### Facilities Updated
Changed from:
```
✅ Laboratorium Akuntansi
✅ Studio Desain & Multimedia
```

To:
```
✅ Bengkel Sepeda Motor (TSM)
✅ Bengkel Kendaraan Ringan (TKR)
```

#### Achievements Updated
Changed from:
```
🥈 Juara 2 Lomba Desain Grafis Nasional
🥉 Juara 3 Olimpiade Akuntansi
```

To:
```
🥈 Juara 2 Lomba Skill Otomotif Nasional
🥉 Juara 3 Kompetisi Mekanik Motor
```

### 2. database/seeders/ChatbotResponseSeeder.php

#### Keywords Updated
Changed from:
```php
'keywords' => ['jurusan', 'program', 'keahlian', 'kompetensi', 'tkj', 'rpl', 'multimedia', 'akuntansi']
```

To:
```php
'keywords' => ['jurusan', 'program', 'keahlian', 'kompetensi', 'tkj', 'tsm', 'tkr', 'otomotif', 'motor', 'mobil']
```

## Testing

### Test Chatbot Responses
1. Open chatbot on website
2. Type: "jurusan apa saja?"
3. Should show: TKJ, TSM, TKR
4. Type: "fasilitas"
5. Should show: Bengkel Sepeda Motor, Bengkel Kendaraan Ringan
6. Type: "prestasi"
7. Should show: Updated achievements

### Test Keywords
Try these keywords to trigger program response:
- "jurusan"
- "program keahlian"
- "tkj"
- "tsm"
- "tkr"
- "otomotif"
- "motor"
- "mobil"

## Emoji Used
- 💻 TKJ (Computer)
- 🏍️ TSM (Motorcycle)
- 🚗 TKR (Car)

## Notes
- All responses are in Indonesian
- Friendly and informative tone maintained
- Emoji usage for better engagement
- Clear career prospects for each major
- Updated facilities to match majors
- Updated achievements to match majors

## Future Updates
If majors change again, update:
1. `app/Http/Controllers/ChatbotController.php`
   - Default response
   - System prompt
   - Program keahlian response
   - Keywords array
   - Facilities list
   - Achievements list

2. `database/seeders/ChatbotResponseSeeder.php`
   - Keywords array

Then run:
```bash
php artisan cache:clear
```
