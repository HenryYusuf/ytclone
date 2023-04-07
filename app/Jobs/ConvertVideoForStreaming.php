<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $destination = '/' . $this->video->uid . '/' . $this->video->uid . '.m3u8';

        $low = (new X264())->setKiloBitrate(250);
        $mid = (new X264())->setKiloBitrate(500);
        $high = (new X264())->setKiloBitrate(1000);

        FFMpeg::fromDisk('videos-temp')
            ->open($this->video->path)
            ->exportForHLS()
            ->addFormat($low)
            ->addFormat($mid)
            ->addFormat($high)
            ->onProgress(function ($progress) {
                $this->video->update([
                    'processing_percentage' => $progress,
                ]);
            })
            ->toDisk('videos')
            ->save($destination);

        $this->video->update([
            'processed' => true,
            'processed_file' => $this->video->uid . '.m3u8',
        ]);

        // Delete temp video
        Storage::disk('videos-temp')->delete($this->video->path);
        Log::info($this->video->path . 'Video has been deleted');
    }
}
