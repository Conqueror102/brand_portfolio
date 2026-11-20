<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The client replaced the six Insights categories with four (Nov 20).
 * Move every existing article to the closest new category. Admins can re-file any article afterwards.
 */
return new class extends Migration
{
    private array $map = [
        'institution-building' => 'institutional-sustainability',
        'governance-succession' => 'institutional-sustainability',
        'professional-services' => 'business-of-professional-services',
        'people-performance' => 'business-of-professional-services',
        'leadership' => 'leadership-execution',
        'intentional-execution' => 'leadership-execution',
    ];

    public function up(): void
    {
        foreach ($this->map as $old => $new) {
            DB::table('articles')->where('category', $old)->update(['category' => $new]);
        }
        // Anything else left over lands in the first category rather than disappearing from filters.
        DB::table('articles')->whereNotIn('category', array_unique(array_values($this->map)))
            ->where('category', '!=', 'future-of-work')
            ->update(['category' => 'institutional-sustainability']);
    }

    public function down(): void
    {
        // Not reversible: several old categories collapse into one.
    }
};
