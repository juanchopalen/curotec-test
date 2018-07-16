<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * Method to search by any column
     * @param  Query $query
     * @param  string $target [description]
     * @return Query
     */
    public function scopeSearch($query, $target)
    {
        if ($target != '') {
            return $query->
                where('id', $target)
                ->orWhere('name', 'like', "%$target%");
        }
    }
}
