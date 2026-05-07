<?php

namespace App\Traits;

use App\Models\SEOMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SEOMeta::class, 'seoable');
    }

    public function updateSEO(array $data): SEOMeta
    {
        return $this->seoMeta()->updateOrCreate(
            ['seoable_id' => $this->id, 'seoable_type' => get_class($this)],
            $data
        );
    }
}
