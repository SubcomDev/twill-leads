<?php

namespace Leads\Twill\Capsules\Leads\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use Leads\Twill\Capsules\Leads\Models\Lead;

class LeadRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Lead $model)
    {
        $this->model = $model;
    }
}
