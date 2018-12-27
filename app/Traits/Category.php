<?php
namespace App\Traits;

/**
 * Trait Label
 * @package App\Traits
 */
trait Category{

    public function all()
    {
        $category = \App\Models\Category::all();
        return $category;
    }
}