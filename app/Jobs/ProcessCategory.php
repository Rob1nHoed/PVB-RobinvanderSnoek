<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Drink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $category;
    
    /**
     * Create a new job instance.
     * 
     * @param string $category
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Een nieuwe categorie aanmaken vanaf de Category model als deze nog niet bestaat
        $category = Category::firstOrCreate(['name' => $this->category]);

        // Selecteer alle dranken waarbij de categorie is opgeslagen als naam en niet id, en die veranderen naar het id van de categorie
        $drinks = Drink::where('category', $this->category)->update([
            'category' => $category->id
        ]);
    }
}
