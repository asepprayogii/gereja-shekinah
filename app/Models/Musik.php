<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musik extends Model
{
    protected $table = 'musik';

    protected $fillable = [
        'judul_lagu', 'penyanyi', 'link_youtube',
        'video_id', 'thumbnail_url', 'urutan',
    ];

    // Otomatis ekstrak Video ID dari link YouTube
    public static function ekstrakVideoId(string $url): ?string
    {
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );
        return $matches[1] ?? null;
    }

    // Otomatis set thumbnail dari video ID
    public function getThumbnailAttribute(): string
    {
        if ($this->video_id) {
            return "https://img.youtube.com/vi/{$this->video_id}/hqdefault.jpg";
        }
        return '/images/default-music.jpg';
    }
}