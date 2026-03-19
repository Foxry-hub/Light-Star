<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Testimonial;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = (string) config('auth.admin_email');
        $adminPassword = (string) config('auth.admin_initial_password');

        if ($adminPassword === '') {
            $adminPassword = Str::random(32);
        }

        // Create Admin
        $adminUser = User::updateOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Admin Light Star',
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
        ]);

        if (is_null($adminUser->email_verified_at)) {
            $adminUser->forceFill(['email_verified_at' => now()])->save();
        }

        // Create Sample Customer
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@lightstar.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Sample Testimonials
        Testimonial::create([
            'name' => 'Rina Wulandari',
            'role_label' => 'Event Organizer',
            'content' => 'Light Star benar-benar menyelamatkan acara kami! Setup streaming yang cepat dan kualitas video yang luar biasa. Tim mereka sangat profesional dan responsif.',
            'is_approved' => true,
        ]);

        Testimonial::create([
            'name' => 'Ahmad Fauzan',
            'role_label' => 'Wedding Planner',
            'content' => 'Klien kami sangat puas dengan hasil live streaming pernikahan. Keluarga yang tidak bisa hadir merasa seolah ada di lokasi. Terima kasih Light Star!',
            'is_approved' => true,
        ]);

        Testimonial::create([
            'name' => 'Diana Putri',
            'role_label' => 'Corporate Manager',
            'content' => 'Sudah 3 kali menggunakan jasa Light Star untuk event perusahaan kami. Selalu konsisten dengan kualitas terbaik. Highly recommended!',
            'is_approved' => true,
        ]);

        Testimonial::create([
            'name' => 'Budi Santoso',
            'role_label' => 'Seminar Organizer',
            'content' => 'Pertama kali menggunakan jasa live streaming dan hasilnya diluar ekspektasi. Tim Light Star sangat kooperatif.',
            'is_approved' => false,
        ]);

        // Sample Portfolios
        Portfolio::create([
            'title' => 'Webinar Nasional Pendidikan',
            'description' => 'Live streaming webinar nasional dengan 5000+ peserta online dari seluruh Indonesia.',
            'thumbnail' => 'assets/images/portfolio-webinar.png',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        Portfolio::create([
            'title' => 'Live Wedding Bali',
            'description' => 'Siaran langsung pernikahan untuk keluarga di luar kota dengan multi-kamera setup.',
            'thumbnail' => 'assets/images/portfolio-wedding.png',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        Portfolio::create([
            'title' => 'Corporate Annual Meeting',
            'description' => 'Event perusahaan Fortune 500 dengan produksi multi-camera dan live translation.',
            'thumbnail' => 'assets/images/portfolio-corporate.png',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        Portfolio::create([
            'title' => 'Live Concert Jakarta',
            'description' => 'Broadcast konser musik dengan kualitas audio premium dan 4 sudut kamera.',
            'thumbnail' => 'assets/images/portfolio-concert.png',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);
    }
}
