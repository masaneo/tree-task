<?php

namespace App\Http\Controllers;

use App\Models\TreeNode;
use Illuminate\Http\Request;

class TreeNodeController extends Controller
{
    public function showTree(){
        $tree = TreeNode::all();

        return view('treeview', compact('tree'));
    }

    public function insertTree(Request $req){

        $tree = $req -> all();

        TreeNode::create($tree);

        return back() -> with('success', 'new tree added!');
    }
}
