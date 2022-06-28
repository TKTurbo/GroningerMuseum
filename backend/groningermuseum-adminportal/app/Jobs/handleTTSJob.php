<?php

namespace App\Jobs;

use App\Models\SubRoute;
use Cion\TextToSpeech\Facades\TextToSpeech;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class handleTTSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     * @var \App\Models\SubRoute
     */
    protected $subroute;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SubRoute $subroute)
    {
        $this->subroute = $subroute->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $location = 'TTS/output'.$this->subroute->id.'.mp3';
        $path = TextToSpeech::disk('media')
            ->saveTo($location)
            ->convert($this->subroute->description);
    }
}
