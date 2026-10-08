{{--
    Upload Loader Component
    Overlay animasi loading untuk SEMUA form yang mengunggah berkas (foto berita,
    galeri, foto profil, logo, slider, dokumen PPDB, dll).

    Tujuan:
    1. Pengguna tahu unggahan sedang berjalan sehingga tidak menutup / memuat ulang
       halaman dan tidak menekan tombol simpan dua kali.
    2. Mencegah error "This site can't be reached" dengan memeriksa batas server
       (post_max_size / upload_max_filesize / max_file_uploads) SEBELUM dikirim.

    Opt-out: tambahkan atribut data-no-upload-loader pada <form> yang sudah
    menangani unggahannya sendiri (mis. unggah bertahap via AJAX).

    API JavaScript:
        UploadLoader.show({ title, detail })
        UploadLoader.setProgress(persen)   // 0-100, mengubah bar jadi determinate
        UploadLoader.hide()
        UploadLoader.inspect(arrayOfFiles) // { count, totalBytes, problems: [] }
--}}

@php
    $uploadLoaderToBytes = function ($value) {
        $value = trim((string) $value);

        if ($value === '' || $value === '-1' || $value === '0') {
            return 0; // 0 = tidak dibatasi
        }

        $unit = strtolower(substr($value, -1));
        $number = (float) $value;

        return (int) match ($unit) {
            'g' => $number * 1024 * 1024 * 1024,
            'm' => $number * 1024 * 1024,
            'k' => $number * 1024,
            default => $number,
        };
    };

    $uploadLoaderConfig = [
        'postMaxSize' => $uploadLoaderToBytes(ini_get('post_max_size')),
        'uploadMaxFilesize' => $uploadLoaderToBytes(ini_get('upload_max_filesize')),
        'maxFileUploads' => max(0, (int) ini_get('max_file_uploads')),
        'maxExecutionTime' => max(0, (int) ini_get('max_execution_time')),
    ];

    $uploadLoaderLogoUrl = \App\Models\Setting::getLogo('site_logo');
@endphp

<div id="upload-loader" class="ulx-overlay" role="status" aria-live="polite" hidden>
    <div class="ulx-card">
        {{-- Tampilan saat mengunggah --}}
        <div data-ulx-view="uploading">
            <div class="ulx-ring">
                <div class="ulx-ring-track"></div>
                <div class="ulx-ring-spin"></div>
                @if($uploadLoaderLogoUrl)
                    <img src="{{ $uploadLoaderLogoUrl }}" alt="" class="ulx-logo" onerror="this.style.display='none';">
                @else
                    <svg class="ulx-logo ulx-logo-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6H16a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                @endif
            </div>

            <h3 class="ulx-title" id="ulx-title">Mengunggah Berkas&hellip;</h3>
            <p class="ulx-meta"><span id="ulx-files">Menyiapkan&hellip;</span><span class="ulx-dot">&bull;</span><span id="ulx-elapsed">00:00</span></p>

            <div class="ulx-bar">
                <div class="ulx-bar-fill ulx-bar-indeterminate" id="ulx-bar-fill"></div>
            </div>
            <p class="ulx-percent" id="ulx-percent" hidden>0%</p>

            <p class="ulx-hint" id="ulx-hint">Berkas sedang dikirim ke server&hellip;</p>
            <p class="ulx-warn">
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.257 3.1c.765-1.36 2.72-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Jangan tutup atau muat ulang halaman ini.
            </p>

            <div class="ulx-actions" id="ulx-actions" hidden>
                <button type="button" class="ulx-btn" id="ulx-cancel">Batalkan &amp; muat ulang</button>
            </div>
        </div>

        {{-- Tampilan saat unggahan ditolak karena melebihi batas server --}}
        <div data-ulx-view="blocked" hidden>
            <div class="ulx-badge-warn" aria-hidden="true">
                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.1c.765-1.36 2.72-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            </div>
            <h3 class="ulx-title">Unggahan Melebihi Batas Server</h3>
            <ul class="ulx-problems" id="ulx-problems"></ul>
            <p class="ulx-hint">
                Kurangi jumlah atau ukuran foto, lalu coba lagi. Untuk foto yang banyak,
                unggah secara bertahap (beberapa kali simpan) agar tidak gagal di tengah jalan.
            </p>
            <div class="ulx-actions">
                <button type="button" class="ulx-btn ulx-btn-primary" id="ulx-close">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<style>
.ulx-overlay {
    position: fixed;
    inset: 0;
    z-index: 99998;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    background: rgba(15, 23, 42, .72);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    opacity: 1;
    transition: opacity .25s ease;
    font-family: Inter, system-ui, -apple-system, "Segoe UI", sans-serif;
}
.ulx-overlay[hidden] { display: none; }
.ulx-overlay.ulx-fading { opacity: 0; }

.ulx-card {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border-radius: 20px;
    padding: 32px 28px 26px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .35);
}

.ulx-ring { position: relative; width: 72px; height: 72px; margin: 0 auto 20px; }
.ulx-ring-track,
.ulx-ring-spin { position: absolute; inset: 0; border-radius: 50%; border: 4px solid transparent; }
.ulx-ring-track { border-color: #dbeafe; }
.ulx-ring-spin {
    border-top-color: #2563eb;
    border-right-color: #2563eb;
    animation: ulx-spin 1s linear infinite;
}
.ulx-logo {
    position: absolute;
    inset: 0;
    width: 36px;
    height: 36px;
    margin: auto;
    object-fit: contain;
    border-radius: 8px;
    animation: ulx-pulse 1.8s ease-in-out infinite;
}
.ulx-logo-svg { color: #2563eb; }

.ulx-title { margin: 0 0 6px; font-size: 17px; font-weight: 700; color: #111827; }
.ulx-meta { margin: 0 0 16px; font-size: 13px; color: #6b7280; }
.ulx-dot { margin: 0 7px; opacity: .55; }

.ulx-bar {
    position: relative;
    height: 8px;
    border-radius: 999px;
    background: #e5e7eb;
    overflow: hidden;
}
.ulx-bar-fill {
    height: 100%;
    width: 0;
    border-radius: 999px;
    background: linear-gradient(90deg, #2563eb, #60a5fa);
    transition: width .25s ease;
}
.ulx-bar-indeterminate {
    width: 40% !important;
    transition: none;
    animation: ulx-slide 1.4s ease-in-out infinite;
}
.ulx-percent { margin: 8px 0 0; font-size: 13px; font-weight: 600; color: #2563eb; }

.ulx-hint { margin: 14px 0 0; font-size: 13px; line-height: 1.5; color: #4b5563; }
.ulx-warn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin: 14px 0 0;
    font-size: 12px;
    font-weight: 600;
    color: #b45309;
}
.ulx-warn svg { width: 15px; height: 15px; flex: 0 0 auto; }

.ulx-badge-warn {
    width: 56px;
    height: 56px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: #fef3c7;
    color: #d97706;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ulx-badge-warn svg { width: 30px; height: 30px; }

.ulx-problems {
    margin: 0;
    padding: 0;
    list-style: none;
    text-align: left;
}
.ulx-problems li {
    position: relative;
    padding: 9px 12px 9px 30px;
    margin-bottom: 8px;
    font-size: 13px;
    line-height: 1.5;
    color: #991b1b;
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 10px;
}
.ulx-problems li::before {
    content: "!";
    position: absolute;
    left: 10px;
    top: 9px;
    width: 14px;
    height: 14px;
    font-size: 10px;
    font-weight: 700;
    line-height: 14px;
    text-align: center;
    color: #fff;
    background: #dc2626;
    border-radius: 50%;
}

.ulx-actions { margin-top: 18px; display: flex; justify-content: center; gap: 10px; }
.ulx-btn {
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
    transition: background .15s ease;
}
.ulx-btn:hover { background: #e5e7eb; }
.ulx-btn-primary { color: #fff; background: #2563eb; border-color: #2563eb; }
.ulx-btn-primary:hover { background: #1d4ed8; }

/* Ringkasan di bawah setiap input berkas */
.ulx-summary {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 8px 11px;
    font-size: 12.5px;
    line-height: 1.5;
    color: #1e40af;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
}
.ulx-summary strong { font-weight: 700; }
.ulx-summary.ulx-summary-danger {
    color: #991b1b;
    background: #fef2f2;
    border-color: #fecaca;
}
.ulx-summary-note { display: block; width: 100%; font-size: 12px; opacity: .9; }

.ulx-locked { opacity: .6; cursor: progress !important; }

@keyframes ulx-spin { to { transform: rotate(360deg); } }
@keyframes ulx-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.09); }
}
@keyframes ulx-slide {
    0% { transform: translateX(-110%); }
    100% { transform: translateX(260%); }
}

@media (prefers-reduced-motion: reduce) {
    .ulx-ring-spin, .ulx-logo, .ulx-bar-indeterminate { animation: none; }
    .ulx-bar-indeterminate { width: 100% !important; opacity: .55; }
}
</style>

<script>
(function () {
    'use strict';

    if (window.UploadLoader) return;

    var CONFIG = @json($uploadLoaderConfig);

    var overlay = document.getElementById('upload-loader');
    if (!overlay) return;

    var viewUploading = overlay.querySelector('[data-ulx-view="uploading"]');
    var viewBlocked = overlay.querySelector('[data-ulx-view="blocked"]');
    var elTitle = document.getElementById('ulx-title');
    var elFiles = document.getElementById('ulx-files');
    var elElapsed = document.getElementById('ulx-elapsed');
    var elBar = document.getElementById('ulx-bar-fill');
    var elPercent = document.getElementById('ulx-percent');
    var elHint = document.getElementById('ulx-hint');
    var elActions = document.getElementById('ulx-actions');
    var elProblems = document.getElementById('ulx-problems');

    var timer = null;
    var startedAt = 0;
    var active = false;

    // Pesan bertahap supaya pengguna tetap tenang pada unggahan yang lama
    var STAGES = [
        { after: 0, text: 'Berkas sedang dikirim ke server...' },
        { after: 10, text: 'Masih berjalan. Semakin besar fotonya, semakin lama prosesnya.' },
        { after: 30, text: 'Mohon tunggu, unggahan foto berukuran besar memang butuh waktu.' },
        { after: 60, text: 'Masih mengunggah. Jika sering gagal, coba unggah lebih sedikit foto sekaligus.' },
        { after: 120, text: 'Koneksi Anda terdeteksi lambat. Tetap tunggu, atau batalkan dan unggah bertahap.' }
    ];

    function formatBytes(bytes) {
        if (!bytes) return '0 MB';
        var mb = bytes / 1048576;
        if (mb >= 1024) return (mb / 1024).toFixed(2).replace('.', ',') + ' GB';
        if (mb >= 1) return mb.toFixed(1).replace('.', ',') + ' MB';
        return Math.max(1, Math.round(bytes / 1024)) + ' KB';
    }

    function formatDuration(seconds) {
        var m = Math.floor(seconds / 60);
        var s = seconds % 60;
        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    function filesOf(form) {
        var files = [];
        Array.prototype.forEach.call(form.querySelectorAll('input[type="file"]'), function (input) {
            if (input.disabled || !input.files) return;
            Array.prototype.forEach.call(input.files, function (file) { files.push(file); });
        });
        return files;
    }

    // Periksa batas server sebelum berkas dikirim
    function inspect(files) {
        var totalBytes = files.reduce(function (sum, file) { return sum + file.size; }, 0);
        var problems = [];

        if (CONFIG.maxFileUploads > 0 && files.length > CONFIG.maxFileUploads) {
            problems.push('Server hanya menerima <strong>' + CONFIG.maxFileUploads + ' berkas</strong> dalam satu kali kirim, sedangkan Anda memilih <strong>' + files.length + ' berkas</strong>.');
        }

        if (CONFIG.uploadMaxFilesize > 0) {
            var tooBig = files.filter(function (file) { return file.size > CONFIG.uploadMaxFilesize; });
            if (tooBig.length) {
                problems.push('Ukuran maksimal per berkas adalah <strong>' + formatBytes(CONFIG.uploadMaxFilesize) + '</strong>. Berkas yang terlalu besar: <strong>' + tooBig.map(function (file) { return file.name; }).join(', ') + '</strong>.');
            }
        }

        // multipart menambah overhead; beri margin 5% + 1 KB per berkas
        var estimated = Math.round(totalBytes * 1.05) + (files.length * 1024);
        if (CONFIG.postMaxSize > 0 && estimated > CONFIG.postMaxSize) {
            problems.push('Total unggahan <strong>' + formatBytes(totalBytes) + '</strong> melebihi batas sekali kirim <strong>' + formatBytes(CONFIG.postMaxSize) + '</strong>.');
        }

        return { count: files.length, totalBytes: totalBytes, problems: problems };
    }

    function setView(name) {
        viewUploading.hidden = name !== 'uploading';
        viewBlocked.hidden = name !== 'blocked';
    }

    function openOverlay() {
        overlay.classList.remove('ulx-fading');
        overlay.hidden = false;
    }

    function closeOverlay() {
        overlay.classList.add('ulx-fading');
        window.setTimeout(function () {
            if (overlay.classList.contains('ulx-fading')) overlay.hidden = true;
        }, 250);
    }

    function tick() {
        var seconds = Math.floor((Date.now() - startedAt) / 1000);
        elElapsed.textContent = formatDuration(seconds);

        for (var i = STAGES.length - 1; i >= 0; i--) {
            if (seconds >= STAGES[i].after) {
                if (elHint.textContent !== STAGES[i].text) elHint.textContent = STAGES[i].text;
                break;
            }
        }

        if (seconds >= 90) elActions.hidden = false;
    }

    function show(options) {
        options = options || {};
        active = true;

        setView('uploading');
        elTitle.textContent = options.title || 'Mengunggah Berkas...';
        elFiles.textContent = options.detail || 'Menyiapkan...';
        elHint.textContent = STAGES[0].text;
        elActions.hidden = true;
        elPercent.hidden = true;
        elBar.classList.add('ulx-bar-indeterminate');
        elBar.style.width = '';

        startedAt = Date.now();
        elElapsed.textContent = '00:00';
        window.clearInterval(timer);
        timer = window.setInterval(tick, 1000);

        openOverlay();
    }

    function setProgress(percent) {
        if (typeof percent !== 'number' || isNaN(percent)) return;
        var value = Math.max(0, Math.min(100, Math.round(percent)));
        elBar.classList.remove('ulx-bar-indeterminate');
        elBar.style.width = value + '%';
        elPercent.hidden = false;
        elPercent.textContent = value + '%';
    }

    function hide() {
        active = false;
        window.clearInterval(timer);
        timer = null;
        closeOverlay();
    }

    function showBlocked(problems) {
        elProblems.innerHTML = '';
        problems.forEach(function (text) {
            var li = document.createElement('li');
            li.innerHTML = text;
            elProblems.appendChild(li);
        });
        setView('blocked');
        openOverlay();
    }

    function lockSubmitButtons(form) {
        var buttons = form.querySelectorAll('button[type="submit"], input[type="submit"], button:not([type])');
        // Ditunda agar nama/nilai tombol tetap terkirim bersama form
        window.setTimeout(function () {
            Array.prototype.forEach.call(buttons, function (button) {
                button.disabled = true;
                button.classList.add('ulx-locked');
            });
        }, 0);
    }

    // --- Ringkasan langsung saat pengguna memilih berkas -------------------
    function renderSummary(input) {
        var host = input.parentNode;
        if (!host || !host.appendChild) return;

        var existing = host.querySelector('.ulx-summary');
        var summary = (existing && existing.parentNode === host) ? existing : null;
        var files = input.files ? Array.prototype.slice.call(input.files) : [];

        if (!files.length) {
            if (summary) summary.parentNode.removeChild(summary);
            return;
        }

        if (!summary) {
            summary = document.createElement('div');
            summary.className = 'ulx-summary';
            host.appendChild(summary);
        }

        var form = input.form;
        var skipChecks = form ? form.hasAttribute('data-no-upload-loader') : true;
        var result = inspect(files);
        var label = '<span><strong>' + files.length + '</strong> berkas dipilih &bull; <strong>' + formatBytes(result.totalBytes) + '</strong></span>';

        if (!skipChecks && result.problems.length) {
            summary.className = 'ulx-summary ulx-summary-danger';
            summary.innerHTML = label + '<span class="ulx-summary-note">Melebihi batas server &mdash; kurangi jumlah atau ukuran berkas sebelum menyimpan.</span>';
        } else {
            summary.className = 'ulx-summary';
            summary.innerHTML = label + (files.length > 5
                ? '<span class="ulx-summary-note">Unggahan banyak foto butuh waktu. Biarkan halaman terbuka sampai selesai.</span>'
                : '');
        }
    }

    document.addEventListener('change', function (event) {
        var input = event.target;
        if (input && input.tagName === 'INPUT' && input.type === 'file') renderSummary(input);
    });

    // --- Pasang otomatis ke semua form unggahan ---------------------------
    document.addEventListener('submit', function (event) {
        // Form yang menangani unggahannya sendiri (AJAX) sudah memanggil preventDefault
        if (event.defaultPrevented) return;

        var form = event.target;
        if (!form || form.tagName !== 'FORM') return;
        if (form.hasAttribute('data-no-upload-loader')) return;

        // Cegah kirim ganda selama unggahan berjalan
        if (form.getAttribute('data-ulx-locked') === '1') {
            event.preventDefault();
            return;
        }

        var files = filesOf(form);
        if (!files.length) return;

        var result = inspect(files);

        if (result.problems.length) {
            event.preventDefault();
            showBlocked(result.problems);
            return;
        }

        // Catatan: TIDAK memasang beforeunload di sini. Submit form native memicu
        // beforeunload sehingga browser akan menampilkan dialog "Leave site?"
        // pada setiap unggahan. Peringatan cukup lewat teks di overlay.
        form.setAttribute('data-ulx-locked', '1');
        lockSubmitButtons(form);
        show({
            title: result.count > 1 ? 'Mengunggah ' + result.count + ' Berkas...' : 'Mengunggah Berkas...',
            detail: result.count + ' berkas • ' + formatBytes(result.totalBytes)
        });
    });

    document.getElementById('ulx-close').addEventListener('click', function () {
        closeOverlay();
    });

    document.getElementById('ulx-cancel').addEventListener('click', function () {
        if (!window.confirm('Batalkan unggahan dan muat ulang halaman? Berkas yang belum selesai terkirim akan hilang.')) return;
        if (window.stop) window.stop();
        window.location.reload();
    });

    // Halaman dipulihkan dari cache (tombol Back) - jangan biarkan overlay menggantung
    window.addEventListener('pageshow', function (event) {
        if (!event.persisted && !active) return;

        Array.prototype.forEach.call(document.querySelectorAll('form[data-ulx-locked="1"]'), function (form) {
            form.setAttribute('data-ulx-locked', '0');
            Array.prototype.forEach.call(form.querySelectorAll('.ulx-locked'), function (button) {
                button.disabled = false;
                button.classList.remove('ulx-locked');
            });
        });

        hide();
    });

    window.UploadLoader = {
        config: CONFIG,
        show: show,
        hide: hide,
        setProgress: setProgress,
        inspect: inspect,
        formatBytes: formatBytes
    };
})();
</script>
