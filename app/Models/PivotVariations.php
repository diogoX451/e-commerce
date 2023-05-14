<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PivotVariations extends Pivot {
    protected $table = 'variationCatOption';
}