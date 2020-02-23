<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $helpCategory = Category::firstOrNew(['name' => 'help']);
        $helpCategory->fill([
            'slug' => Str::slug('help'),
            'color' => 'red'
        ]);
        $helpCategory->save();

        $bugCategory = Category::firstOrNew(['name' => 'bug']);
        $bugCategory->fill([
            'slug' => Str::slug('bug'),
            'color' => 'orange'
        ]);
        $bugCategory->save();

        $ideasCategory = Category::firstOrNew(['name' => 'ideas']);
        $ideasCategory->fill([
            'slug' => Str::slug('ideas'),
            'color' => 'blue'
        ]);
        $ideasCategory->save();

        $otherCategory = Category::firstOrNew(['name' => 'other']);
        $otherCategory->fill([
            'slug' => Str::slug('other'),
            'color' => 'gray',
        ]);
        $otherCategory->save();

        $miscCategory = Category::firstOrNew(['name' => 'misc']);
        $miscCategory->fill([
            'slug' => Str::slug('misc'),
            'color' => 'lightblue'
        ]);
        $miscCategory->save();
    }
}
