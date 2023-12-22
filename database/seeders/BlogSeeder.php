<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlogKategori;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $blogKategori = BlogKategori::count();

        if ($blogKategori == 0) {
            $tempKategori = [
                [
                    'title' => 'Berita',
                    'slug' => 'berita',
                    'content' => 'Berita',
                ],
                [
                    'title' => 'Artikel',
                    'slug' => 'artikel',
                    'content' => 'Artikel',
                ],
                [
                    'title' => 'Pemberitahuan',
                    'slug' => 'pemberitahuan',
                    'content' => 'Pemberitahuan',
                ],
            ];

            foreach ($tempKategori as $tk) {
                BlogKategori::create([
                    'title' => $tk['title'],
                    'slug' => $tk['slug'],
                    'content' => $tk['content'],
                ]);
            }
        }
        $blogTag = BlogTag::count();

        if ($blogTag == 0) {
            $tempTag = [
                [
                    'title' => 'KPB',
                    'slug' => 'kpb',
                    'content' => 'KPB',
                ],
                [
                    'title' => 'Lampung',
                    'slug' => 'lampung',
                    'content' => 'Lampung',
                ],
                [
                    'title' => 'BandarLampung',
                    'slug' => 'bandar-lampung',
                    'content' => 'BandarLampung',
                ],
                [
                    'title' => 'ProvinsiLampung',
                    'slug' => 'provinsi-lampung',
                    'content' => 'ProvinsiLampung',
                ],
            ];

            foreach ($tempTag as $tt) {
                BlogTag::create([
                    'title' => $tt['title'],
                    'slug' => $tt['slug'],
                    'content' => $tt['content'],
                ]);
            }
        }

        $post = BlogPost::count();
        if ($post == 0) {
            $tag = BlogTag::get()->toArray();
            $kategori = BlogKategori::get();
            $admin = Admin::first();

            for ($i = 0; $i < 50; $i++) {
                $tempB = BlogPost::create([
                    'admin_id' => $admin->admin_id,
                    'title' => substr($faker->slug, 0, 70),
                    'slug' => substr($faker->slug, 0, 70),
                    'summary' => substr($faker->slug, 0, 70),
                    'content' => substr($faker->slug, 0, 70),
                    'published' => true,
                    'published_at' => date('Y-m-d H:i:s')
                ]);

                for ($i = 0; $i < 3; $i++) {
                    DB::table('blog_post_tag')->insert([
                        'blog_post_id' => $tempB->blog_post_id,
                        'blog_tag_id' => $tag[rand(0, count($tag) - 1)]['blog_tag_id']
                    ]);
                }

                for ($i = 0; $i < 3; $i++) {
                    DB::table('blog_post_kategori')->insert([
                        'blog_post_id' => $tempB->blog_post_id,
                        'blog_kategori_id' => $kategori[rand(0, count($kategori) - 1)]['blog_kategori_id']
                    ]);
                }

                if ($i == 50) {
                    return;
                    exit;
                }
            }
        }
    }
}
