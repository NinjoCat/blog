<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const POSTS_COUNT = 15;
    const REVISIONS_COUNT = 10;
    const TAGS_COUNT = 5;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, self::POSTS_COUNT)->create()->each(function ($post)  {
            for ($i = 1; $i <= self::REVISIONS_COUNT; $i++) {
                $attr = [];
                if ($i == self::REVISIONS_COUNT) {
                    $attr = ['status' => \App\Revision::STATUS['ACTIVE']];
                }
                $post->revisions()->save(factory(App\Revision::class)->make($attr));
            }

            factory(App\Tag::class, self::TAGS_COUNT)->create()->each(function ($tag) use($post) {
                $postTag = new \App\PostTag();
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tag->id;
                $postTag->save();
            });
        });
    }
}
