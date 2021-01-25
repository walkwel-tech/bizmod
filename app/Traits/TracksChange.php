<?php

namespace App\Traits;

use App\User;

trait TracksChange {

    public static function bootTracksChange()
    {
        static::creating (function ($model) {
            $model->creator_id = auth()->user()->id ?? $model->creator_id;
        });

        static::saving (function ($model) {
            $model->updator_id = auth()->user()->id ?? $model->updator_id;
        });
    }

    public function getCreatorName()
    {
        $name = $this->creator->name ?? 'Unknown';

        return $name;
    }

    public function getCreationString()
    {
        if ($this->created_at) {
            $message = 'Created on ' . $this->created_at->format('Y-m-d, H:i:s');
        } else {
            $message = '';
        }

        if ($this->creator) {
            $message .= ' by ' . $this->creator->name;
        }

        return $message;
    }

    public function getUpdationString()
    {
        if ($this->updated_at) {
            $message = 'Last updated on ' . $this->updated_at->format('Y-m-d, H:i:s');
        } else {
            $message = '';
        }


        if ($this->updator) {
            $message .= ' by ' . $this->updator->name;
        }

        return $message;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updator_id');
    }

}
