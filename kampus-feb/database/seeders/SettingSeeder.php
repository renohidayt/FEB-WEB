<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // GENERAL INFO
            [
                'key' => 'site_name',
                'value' => 'FEB UNSAP',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Nama Website',
                'description' => 'Nama website yang ditampilkan',
                'order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Fakultas Ekonomi & Bisnis Universitas Sebelas April',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat website',
                'order' => 2,
            ],

            // CONTACT INFO
            [
                'key' => 'contact_phone',
                'value' => '+6285211116071',
                'group' => 'contact',
                'type' => 'phone',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon utama',
                'order' => 1,
            ],
            [
                'key' => 'contact_email',
                'value' => 'feb@unsap.ac.id',
                'group' => 'contact',
                'type' => 'email',
                'label' => 'Email Resmi',
                'description' => 'Alamat email resmi',
                'order' => 2,
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6285315654194',
                'group' => 'contact',
                'type' => 'phone',
                'label' => 'WhatsApp',
                'description' => 'Nomor WhatsApp (tanpa + dan spasi)',
                'order' => 3,
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Angkrek Situ No.19, Kec. Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45323',
                'group' => 'contact',
                'type' => 'textarea',
                'label' => 'Alamat Lengkap',
                'description' => 'Alamat kampus lengkap',
                'order' => 4,
            ],
            [
                'key' => 'contact_map_embed',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.437233140183!2d107.9218514!3d-6.8380724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68d134803226a9%3A0x1b0a2ac71fe55ece!2sUniversitas%20Sebelas%20April!5e0!3m2!1sid!2sid!4v1765788830608',
                'group' => 'contact',
                'type' => 'url',
                'label' => 'Google Maps Embed URL',
                'description' => 'URL embed dari Google Maps',
                'order' => 5,
            ],
            [
                'key' => 'contact_map_link',
                'value' => 'https://www.google.com/maps/place/Universitas+Sebelas+April/@-6.8380724,107.9218514,17z',
                'group' => 'contact',
                'type' => 'url',
                'label' => 'Google Maps Link',
                'description' => 'Link langsung ke Google Maps',
                'order' => 6,
            ],

            // SOCIAL MEDIA
            [
                'key' => 'social_instagram',
                'value' => 'https://www.instagram.com/febsascredible?igsh=MTYxNG9zOXEyOHQ0cA==',
                'group' => 'social_media',
                'type' => 'url',
                'label' => 'Instagram',
                'description' => 'Link profil Instagram',
                'order' => 1,
            ],
            [
                'key' => 'social_facebook',
                'value' => '#',
                'group' => 'social_media',
                'type' => 'url',
                'label' => 'Facebook',
                'description' => 'Link halaman Facebook',
                'order' => 2,
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@febunsap?si=QT00xSOo1jeYtXxd',
                'group' => 'social_media',
                'type' => 'url',
                'label' => 'YouTube',
                'description' => 'Link channel YouTube',
                'order' => 3,
            ],
            [
                'key' => 'social_twitter',
                'value' => '#',
                'group' => 'social_media',
                'type' => 'url',
                'label' => 'Twitter / X',
                'description' => 'Link profil Twitter/X',
                'order' => 4,
            ],
            [
                'key' => 'social_linkedin',
                'value' => '#',
                'group' => 'social_media',
                'type' => 'url',
                'label' => 'LinkedIn',
                'description' => 'Link profil LinkedIn',
                'order' => 5,
            ],

            // WORKING HOURS
            [
                'key' => 'hours_weekday',
                'value' => '07.00 - 16.00',
                'group' => 'working_hours',
                'type' => 'text',
                'label' => 'Jam Kerja (Senin - Sabtu)',
                'description' => 'Jam operasional hari kerja',
                'order' => 1,
            ],
            [
                'key' => 'hours_sunday',
                'value' => 'TUTUP',
                'group' => 'working_hours',
                'type' => 'text',
                'label' => 'Jam Kerja (Minggu)',
                'description' => 'Jam operasional hari Minggu',
                'order' => 2,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}