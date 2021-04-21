<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait PerformsSEO {
    use PerformsBasicSEO;

    public function getSEODescription($maxNbWords = null)
    {
        $maxNbWords = $maxNbWords ?? config('widgets.seo.maxwords', 30);

        $description = $this->getCompleteDescription(true);

        return Str::limit(Str::words($description, $maxNbWords), config('widgets.seo.maxlength', 55));
    }
    public function getSEOContent($maxNbWords = null)
    {
        $maxNbWords = $maxNbWords ?? config('widgets.seo.maxwords', 30);

        $content = $this->getCompleteContent(true);

        return Str::limit(Str::words($content, $maxNbWords), config('widgets.seo.maxlength', 55));
    }

    public function getCompleteDescription($safe = false)
    {
        $description = ($safe)
                        ? strip_tags($this->description)
                        : $this->description;

        return $description;
    }
    public function getCompleteContent($safe = false)
    {
        $content = ($safe)
                        ? strip_tags($this->content)
                        : $this->content;

        return $content;
    }

    public function getCompleteContentFormated()
    {
        $content = $this->content;
        $content = str_replace('{% user_avatar %}', auth()->user()->getImage(),$content);
        $content = str_replace('{% user_name %}', auth()->user()->name,$content);

        return htmlspecialchars_decode($content);
    }
}
