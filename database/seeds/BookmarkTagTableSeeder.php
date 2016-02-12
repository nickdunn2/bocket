<?php

use App\Tag;
use App\Bookmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookmarkTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookmark::truncate();
        Tag::truncate();
        DB::table('bookmark_tag')->truncate();
        factory(Bookmark::class, 50)
            ->create()
            ->each(function($bookmark) {
                $tagIds = factory(Tag::class, 2)->create()->pluck('id')->toArray();
                $bookmark->tags()->sync($tagIds);
            });
    }
}
