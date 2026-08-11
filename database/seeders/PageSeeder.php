<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'home' => [
                'name' => 'Home',
                'contents' => [
                    'meta_title' => 'Ruang Cinema',
                    'meta_description' => 'Temukan film, baca review, berikan komentar, dan simpan film favoritmu.',
                    'hero_label' => 'Your Personal Cinema Space',
                    'hero_title' => 'Discover Your',
                    'hero_title_accent' => 'Next Favorite Movie.',
                    'hero_description' => 'Temukan film yang ingin kamu tonton, baca review, bagikan pendapatmu, dan simpan film favoritmu dalam satu ruang.',
                    'hero_primary_cta' => 'Explore Movies',
                    'hero_secondary_cta' => 'Learn More',
                    'feature_label' => 'Everything You Need',
                    'feature_title' => 'Your Movie Experience,',
                    'feature_title_accent' => 'All in One Place.',
                    'feature_description' => 'Ruang Cinema membantu kamu menemukan film, membaca pendapat komunitas, dan menyimpan film yang ingin kamu tonton kembali.',
                    'trending_label' => 'Trending Movies',
                    'trending_title' => 'Stories Worth',
                    'trending_title_accent' => 'Watching.',
                    'trending_description' => 'Film yang sedang populer minggu ini.',
                    'trending_cta' => 'View All Movies',
                    'about_label' => 'Why Ruang Cinema',
                    'about_title' => 'Mengapa Ruang Cinema?',
                    'community_label' => 'Community Voices',
                    'community_title' => 'Apa Kata Mereka?',
                ],
            ],
            'movies' => [
                'name' => 'Movies',
                'contents' => [
                    'meta_title' => 'Movies - Ruang Cinema',
                    'meta_description' => 'Temukan berbagai film favoritmu di Ruang Cinema.',
                    'hero_label' => 'Ruang Cinema',
                    'hero_title' => 'Movies',
                    'hero_description' => 'Temukan film favoritmu. Review, rating, dan simpan film yang ingin kamu tonton.',
                ],
            ],
            'about' => [
                'name' => 'About',
                'contents' => [
                    'label' => 'Why Ruang Cinema',
                    'title' => 'Mengapa Ruang Cinema?',
                    'community_label' => 'Community Voices',
                    'community_title' => 'Apa Kata Mereka?',
                ],
            ],
        ];

        foreach ($pages as $slug => $definition) {
            $page = Page::updateOrCreate(['slug' => $slug], ['name' => $definition['name']]);

            foreach ($definition['contents'] as $key => $value) {
                $page->contents()->updateOrCreate(
                    ['section' => 'default', 'key' => $key],
                    ['value' => $value, 'type' => 'text']
                );
            }
        }
    }
}
