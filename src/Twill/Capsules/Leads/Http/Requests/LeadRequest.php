<?php

namespace Leads\Twill\Capsules\Leads\Http\Requests;

use A17\Twill\Http\Requests\Admin\Request;

class LeadRequest extends Request
{
    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        return [];
    }
}
