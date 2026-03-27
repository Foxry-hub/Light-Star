<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users:sync-names-from-email {--email=} {--force}', function () {
    $emailFilter = trim((string) $this->option('email'));
    $applyChanges = (bool) $this->option('force');

    $users = User::query()
        ->when($emailFilter !== '', function ($query) use ($emailFilter) {
            $query->where('email', $emailFilter);
        })
        ->whereNotNull('email')
        ->orderBy('id')
        ->get(['id', 'name', 'email']);

    $updates = [];

    foreach ($users as $user) {
        $currentName = trim((string) $user->name);

        // Skip users that already have multi-word names.
        if ($currentName !== '' && str_contains($currentName, ' ')) {
            continue;
        }

        $emailLocalPart = strtolower((string) strstr((string) $user->email, '@', true));

        // We can safely infer full name only if email uses separators (dot/underscore/hyphen).
        if ($emailLocalPart === '' || !preg_match('/[._-]/', $emailLocalPart)) {
            continue;
        }

        $candidate = str_replace(['.', '_', '-'], ' ', $emailLocalPart);
        $candidate = preg_replace('/\s+/', ' ', (string) $candidate);
        $candidate = trim((string) $candidate);

        if ($candidate === '') {
            continue;
        }

        $candidate = Str::title($candidate);

        if (Str::lower($currentName) === Str::lower($candidate)) {
            continue;
        }

        $updates[] = [
            'id' => $user->id,
            'email' => $user->email,
            'before' => $currentName === '' ? '(kosong)' : $currentName,
            'after' => $candidate,
        ];
    }

    if (empty($updates)) {
        $this->info('Tidak ada user yang perlu disinkronkan.');
        return;
    }

    $this->table(['ID', 'Email', 'Nama Sebelum', 'Nama Setelah'], $updates);

    if (!$applyChanges) {
        $this->warn('Dry-run selesai. Jalankan lagi dengan --force untuk menyimpan perubahan.');
        return;
    }

    $updatedCount = 0;

    foreach ($updates as $item) {
        $affected = User::query()->where('id', $item['id'])->update(['name' => $item['after']]);
        $updatedCount += (int) $affected;
    }

    $this->info("Berhasil memperbarui {$updatedCount} user.");
})->purpose('Sinkron nama lengkap user dari email lokal (dry-run default).');
