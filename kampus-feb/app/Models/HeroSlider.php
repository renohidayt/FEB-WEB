<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'tagline',
        'button_text',
        'button_link',
        'media_type',
        'media_path',
        'video_embed',
        'video_platform',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accessor untuk full URL media path
    public function getMediaUrlAttribute()
    {
        if ($this->media_path) {
            return Storage::url($this->media_path);
        }
        return null;
    }

    // Ekstrak YouTube video ID
    public function getYouTubeVideoId()
    {
        if ($this->video_platform !== 'youtube' || !$this->video_embed) {
            return null;
        }

        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/v\/([^?]+)/',
            '/youtube\.com\/shorts\/([^?]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video_embed, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    // Ekstrak Vimeo video ID
    public function getVimeoVideoId()
    {
        if ($this->video_platform !== 'vimeo' || !$this->video_embed) {
            return null;
        }

        preg_match('/vimeo\.com\/(\d+)/', $this->video_embed, $match);
        return $match[1] ?? null;
    }

    // Ekstrak Wistia video ID
    public function getWistiaVideoId()
    {
        if ($this->video_platform !== 'wistia' || !$this->video_embed) {
            return null;
        }

        // Pattern untuk berbagai format URL Wistia
        $patterns = [
            '/wistia\.com\/medias\/([a-z0-9]+)/i',
            '/fast\.wistia\.net\/embed\/iframe\/([a-z0-9]+)/i',
            '/fast\.wistia\.com\/embed\/iframe\/([a-z0-9]+)/i',
            '/home\.wistia\.com\/medias\/([a-z0-9]+)/i',
            '/([a-z0-9]{10})$/i', // Jika hanya ID yang diinput
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video_embed, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    // Get embed URL berdasarkan platform
    public function getEmbedUrl()
    {
        if ($this->video_platform === 'youtube') {
            $videoId = $this->getYouTubeVideoId();
            if ($videoId) {
                return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&loop=1&playlist={$videoId}&controls=0&showinfo=0&rel=0&modestbranding=1";
            }
        }

        if ($this->video_platform === 'vimeo') {
            $videoId = $this->getVimeoVideoId();
            if ($videoId) {
                return "https://player.vimeo.com/video/{$videoId}?autoplay=1&muted=1&loop=1&background=1";
            }
        }

        if ($this->video_platform === 'wistia') {
            $videoId = $this->getWistiaVideoId();
            if ($videoId) {
                return "https://fast.wistia.net/embed/iframe/{$videoId}?autoPlay=true&muted=true&endVideoBehavior=loop&videoFoam=true&controlsVisibleOnLoad=false&playButton=false";
            }
        }

        return $this->video_embed;
    }

    // Get Wistia embed options untuk custom player
    public function getWistiaEmbedOptions()
    {
        if ($this->video_platform !== 'wistia') {
            return null;
        }

        $videoId = $this->getWistiaVideoId();
        if (!$videoId) {
            return null;
        }

        return [
            'videoId' => $videoId,
            'options' => [
                'autoPlay' => true,
                'muted' => true,
                'endVideoBehavior' => 'loop',
                'videoFoam' => true,
                'controlsVisibleOnLoad' => false,
                'playButton' => false,
                'fullscreenButton' => false,
                'playbar' => false,
                'smallPlayButton' => false,
                'volumeControl' => false,
                'settingsControl' => false,
            ]
        ];
    }
}