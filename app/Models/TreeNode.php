<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeNode extends Model
{
    use HasFactory;

    protected $table = 'treenodes';

    protected $fillable = [
        'parentId',
        'name',
    ];

    public function childs() {
        return $this -> hasMany(TreeNode::class, 'parentId', 'id');
    }
}
