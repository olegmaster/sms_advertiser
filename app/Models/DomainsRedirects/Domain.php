<?php

namespace App\Models\DomainsRedirects;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['domain', 'spam_limit', 'freeze_hours'];


}
