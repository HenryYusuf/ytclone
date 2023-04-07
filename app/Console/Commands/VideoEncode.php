<?php

namespace App\Console\Commands;

use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoEncode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-encode:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Video Encoding';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $low = (new X264())->setKiloBitrate(250);
        $mid = (new X264())->setKiloBitrate(500);
        $high = (new X264())->setKiloBitrate(1000);

        FFMpeg::fromDisk('videos-temp')
            ->open('batu.mp4')
            ->exportForHLS()
            ->addFormat($low)
            ->addFormat($mid)
            ->addFormat($high)
            ->onProgress(function ($progress) {
                $this->info("Progress: {$progress}%");
            })
            ->toDisk('videos-temp')
            ->save('/test/file.m3u8');
    }
}
