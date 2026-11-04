<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

/** Adds the launch lists (topics, organisations, FAQs…) once. Safe to run again: lists that already have items are left alone. */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Arr::except(config('collections'), 'icons') as $type => $definition) {
            if (Item::where('type', $type)->exists()) {
                continue;
            }
            foreach ($definition['seed'] ?? [] as $position => $row) {
                Item::create($row + ['type' => $type, 'sort_order' => $position, 'is_published' => true]);
            }
        }
    }
}
