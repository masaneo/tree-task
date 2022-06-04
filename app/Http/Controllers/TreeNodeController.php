<?php

namespace App\Http\Controllers;

use App\Models\TreeNode;
use Illuminate\Http\Request;

class TreeNodeController extends Controller
{
    public function showTree(){
        $root = TreeNode::where('parentId', '=', '0')->get();
        $tree = TreeNode::pluck('name', 'id')->all();

        return view('treeview', compact('tree', 'root'));
    }

    public function insertNode(Request $req){

        $tree = $req -> all();

        if(!isset($tree->parentId)){
            $tree['parentId'] = 0;
        }

        if(TreeNode::create($tree)){
            return back() -> with('succeed', 'Udało się utworzyć node');
        };

        return back() -> with('failed', 'Nie udało się utworzyć node');
    }

    public function deleteNode(Request $req){
        $id = $req -> all('id');
        
        if(TreeNode::destroy($id)){
            return back() -> with('succeed', 'Pomyślnie usunięto node');
        } 

        return back() -> with('failed', 'Nie udało się usunąć node');
    }

    public function editNode(Request $req){
        $data = $req -> all();

        $node = TreeNode::find($data['id']);

        $node->name = $data['name'];

        if($node->save()){
            return back() -> with('succeed', 'Udało się edytować node');
        }

        return back() -> with('failed', 'Nie udało się edytować node');
    }

    public function moveNode(Request $req){
        $moveNode = TreeNode::find($req['moveNodeId']);
        $targetNode = TreeNode::find($req['targetNodeId']);
        
        if(!isset($targetNode)){
            $targetNode = new TreeNode;
            $targetNode->id = 0;
        }

        if(in_array($targetNode -> id, $this -> findAllChildrens($moveNode->id))){
            return back() -> with('failed', 'Docelowy node jest potomkiem wybranego node');
        }

        if($moveNode->id === $targetNode -> id){
            return back() -> with('failed', 'Wybrano dwa razy ten sam node');
        }
        
        $moveNode -> parentId = $targetNode -> id;

        $moveNode -> save();

        return back() -> with('succeed', 'Przeniesiono node');
    }

    public function findAllChildrens($id){
        $parent = TreeNode::find($id);

        $childrenIds = [];

        foreach($parent->childs as $children){
            $childrenIds[] = $children -> id;
            $childrenIds = array_merge($childrenIds, $this->findAllChildrens($children->id));
        }

        return($childrenIds);
    }
}
