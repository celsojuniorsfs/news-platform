<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class () extends Migration {
    public function up(): void
    {
        DB::table('categories')
            ->select(['id', 'name', 'slug'])
            ->orderBy('id')
            ->get()
            ->each(function (object $category): void {
                if ($category->slug !== null && $category->slug !== '') {
                    return;
                }

                DB::table('categories')
                    ->where('id', $category->id)
                    ->update([
                        'slug' => Str::slug((string) $category->name),
                    ]);
            });

        DB::table('news')
            ->select(['id', 'content', 'excerpt'])
            ->orderBy('id')
            ->get()
            ->each(function (object $news): void {
                if ($news->excerpt !== null && $news->excerpt !== '') {
                    return;
                }

                DB::table('news')
                    ->where('id', $news->id)
                    ->update([
                        'excerpt' => Str::limit(trim(strip_tags((string) $news->content)), 180),
                    ]);
            });
    }

    public function down(): void
    {
    }
};

