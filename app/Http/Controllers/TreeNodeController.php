<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TreeNode;
use Illuminate\Http\Request;

class TreeNodeController extends Controller
{
    public function showTree(){
        $root = TreeNode::where('parentId', '=', '0') -> get();
        $tree = TreeNode::pluck('name', 'id') -> all();

        return view('treeview', compact('tree', 'root'));
    }

    public function insertNode(Request $req){

        $tree = $req -> all();

        if($tree['parentId'] === null){
            $tree['parentId'] = 0;
        }

        if(!isset($tree['name'])){
            return back() -> with('failed', 'Nazwa nie może być pusta');
        }

        if(TreeNode::create($tree)){
            return back() -> with('succeed', 'Udało się utworzyć node');
        };

        return back() -> with('failed', 'Nie udało się utworzyć node');
    }

    public function deleteNode(Request $req){
        $id = $req -> input('id');
        $move = $req -> input('move-children');
        $newParent = $req -> input('newParent') !== null ? $req -> input('newParent') : 0;
        
        if(!isset($move)){ $move = false; }
        
        if($move){
            $children = TreeNode::where('parentId', '=', $id) -> get();
            foreach($children as $child){
                $child -> parentId = $newParent;
                $child->save();
            }
            if(TreeNode::destroy($id)){
                return back() -> with('succeed', 'Pomyślnie usunięto node i przeniesiono dzieci');
            } else {
                return back() -> with('failed', 'Nie udało się wykonać danej operacji');
            }
        } else {
            $childrenIds = $this -> findAllChildren($id);
            foreach($childrenIds as $childId){
                TreeNode::destroy($childId);
            }

            TreeNode::destroy($id);

            return back() -> with('succeed', 'Pomyślnie usunięto node i jego dzieci');
        }

        return  back() -> with('failed', 'Nie udało wykonać się danej operacji');
    }

    public function editNode(Request $req){
        $data = $req -> all();

        if(!isset($data['name'])){
            return back() -> with('failed', 'Nazwa nie może być pusta');
        }

        $node = TreeNode::find($data['id']);

        $node->name = $data['name'];

        if($node -> save()){
            return back() -> with('succeed', 'Udało się edytować node');
        }

        return back() -> with('failed', 'Nie udało się edytować node');
    }

    public function moveNode(Request $req){
        $moveNode = TreeNode::find($req['moveNodeId']);
        $targetNode = TreeNode::find($req['targetNodeId']);
        
        if(!isset($targetNode)){
            $targetNode = new TreeNode;
            $targetNode -> id = 0;
        }

        if(in_array($targetNode -> id, $this -> findAllChildren($moveNode -> id))){
            return back() -> with('failed', 'Docelowy node jest potomkiem wybranego node');
        }

        if($moveNode -> id === $targetNode -> id){
            return back() -> with('failed', 'Wybrano dwa razy ten sam node');
        }
        
        $moveNode -> parentId = $targetNode -> id;

        $moveNode -> save();

        return back() -> with('succeed', 'Przeniesiono node');
    }

    public function findAllChildren($id){
        $parent = TreeNode::find($id);

        $childrenIds = [];

        foreach($parent -> childs as $child){
            $childrenIds[] = $child -> id;
            $childrenIds = array_merge($childrenIds, $this -> findAllChildren($child -> id));
        }

        return($childrenIds);
    }

    public function createExampleTree(){
        $nodes = TreeNode::all();
        if(!empty($nodes[0])){
            return back() -> with('failed', 'Najpierw usuń wszystkie node');
        }

        DB::unprepared('call createExampleTree();');
        $nodes = TreeNode::all();

        if(empty($nodes[0])){
            return back() -> with('failed', 'Nie udało się załadować drzewa');
        }

        return back() -> with('succeed', 'Pomyślnie załadowano przykładowe drzewo');
    }

    public function deleteAllNodes(){
        DB::unprepared('call deleteAllNodes();');

        $nodes = TreeNode::all();
        if(empty($nodes[0])){
            return back() -> with('succeed', 'Usunięto wszystkie node');
        }
        return back() -> with('failed', 'Operacja nie powiodła się');
    }
}
