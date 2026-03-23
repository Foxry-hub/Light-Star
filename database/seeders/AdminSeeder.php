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
        $enableDemoData = (bool) config('app.enable_demo_data');

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

        $demoTestimonials = [
            [
                'name' => 'Rina Wulandari',
                'role_label' => 'Event Organizer',
                'content' => 'Light Star benar-benar menyelamatkan acara kami! Setup streaming yang cepat dan kualitas video yang luar biasa. Tim mereka sangat profesional dan responsif.',
                'is_approved' => true,
            ],
            [
                'name' => 'Ahmad Fauzan',
                'role_label' => 'Wedding Planner',
                'content' => 'Klien kami sangat puas dengan hasil live streaming pernikahan. Keluarga yang tidak bisa hadir merasa seolah ada di lokasi. Terima kasih Light Star!',
                'is_approved' => true,
            ],
            [
                'name' => 'Diana Putri',
                'role_label' => 'Corporate Manager',
                'content' => 'Sudah 3 kali menggunakan jasa Light Star untuk event perusahaan kami. Selalu konsisten dengan kualitas terbaik. Highly recommended!',
                'is_approved' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'role_label' => 'Seminar Organizer',
                'content' => 'Pertama kali menggunakan jasa live streaming dan hasilnya diluar ekspektasi. Tim Light Star sangat kooperatif.',
                'is_approved' => false,
            ],
        ];

        $demoPortfolios = [
            [
                'title' => 'Webinar Nasional Pendidikan',
                'description' => 'Live streaming webinar nasional dengan 5000+ peserta online dari seluruh Indonesia.',
                'thumbnail' => 'assets/images/portfolio-webinar.png',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Live Wedding Bali',
                'description' => 'Siaran langsung pernikahan untuk keluarga di luar kota dengan multi-kamera setup.',
                'thumbnail' => 'assets/images/portfolio-wedding.png',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Corporate Annual Meeting',
                'description' => 'Event perusahaan Fortune 500 dengan produksi multi-camera dan live translation.',
                'thumbnail' => 'assets/images/portfolio-corporate.png',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Live Concert Jakarta',
                'description' => 'Broadcast konser musik dengan kualitas audio premium dan 4 sudut kamera.',
                'thumbnail' => 'assets/images/portfolio-concert.png',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
        ];

        if (!$enableDemoData) {
            User::where('email', 'customer@lightstar.com')->delete();

            foreach ($demoTestimonials as $item) {
                Testimonial::where('name', $item['name'])
                    ->where('content', $item['content'])
                    ->delete();
            }

            foreach ($demoPortfolios as $item) {
                Portfolio::where('title', $item['title'])->delete();
            }

            return;
        }

        // Create Sample Customer (idempotent)
        User::updateOrCreate([
            'email' => 'customer@lightstar.com',
        ], [
            'name' => 'Customer Demo',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        foreach ($demoTestimonials as $item) {
            Testimonial::updateOrCreate([
                'name' => $item['name'],
                'content' => $item['content'],
            ], [
                'role_label' => $item['role_label'],
                'is_approved' => $item['is_approved'],
            ]);
        }

        foreach ($demoPortfolios as $item) {
            Portfolio::updateOrCreate([
                'title' => $item['title'],
            ], [
                'description' => $item['description'],
                'thumbnail' => $item['thumbnail'],
                'video_url' => $item['video_url'],
            ]);
        }
    }
}
