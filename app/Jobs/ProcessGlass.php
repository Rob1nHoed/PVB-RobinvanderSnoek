<?php

namespace App\Jobs;

use App\Models\Drink;
use App\Models\Glass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGlass implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $glass;

    /**
     * Create a new job instance.
     */
    public function __construct($glass)
    {
        $this->glass = $glass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Een nieuwe categorie aanmaken vanaf de Glass model als deze nog niet bestaat
        $glass = Glass::firstOrCreate(['name' => $this->glass]);
        
        // Selecteer alle dranken waarbij de categorie is opgeslagen als naam en niet id, en die veranderen naar het id van de categorie
        $drinks = Drink::where('glass', $this->glass)->update([
            'glass' => $glass->id
        ]);
    }
}
