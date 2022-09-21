<?php

namespace Leads\Twill\Capsules\Leads\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class Lead extends Model
{
    use HasBlocks;

    protected $fillable = [
        'email',
        'published',
    ];

}
