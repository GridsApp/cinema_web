<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class BranchItemsController extends Controller
{
    public function render($branch_id) {



        $branch = Branch::whereNull('deleted_at')->where('id', $branch_id)->firstOrFail();

        $route = "/" . Route::getRoutes()->getByName('items.edit')->uri();

        // dd($route);
        $route = str($route)->replace(["{id}", "{item_id}"], [$branch_id, "{id}"])->toString();
//  dd($route);



        $table = (new \twa\uikit\Classes\Table\TableData('Branch Items', 'branch_items'))
            ->selects(['id'])
            ->belongsTo('items', 'item_id',  true)
            ->addColumn("Image", "image", \twa\uikit\Classes\ColumnTypes\Image::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['items.image'])

            ->addColumn("Item", "item", \twa\uikit\Classes\ColumnTypes\Tag::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['items.label'])
    
            ->belongsTo('branches', 'branch_id',  true)
            ->addColumn("Branch", "branch", \twa\uikit\Classes\ColumnTypes\DefaultType::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['branches.label_en'])
      
            // ->addCondition('where', 'price_group_id', $price_group_id)
            // ->addColumn("Label", "label", \twa\uikit\Classes\ColumnTypes\DefaultType::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['label'])
            // ->addColumn("Condensed Label", "condensed_label", \twa\uikit\Classes\ColumnTypes\DefaultType::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['condensed_label'])
            // ->addColumn("Color", "color", \twa\uikit\Classes\ColumnTypes\Colorpicker::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['color'])
            // ->addColumn("Default", "default", \twa\uikit\Classes\ColumnTypes\DefaultType::class, \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['default']);
            ->addTableOperation("Add Item", route('branch-item.create', ['id' => $branch_id]), '<i class="fa-solid fa-plus"></i>');

        // if (cms_check_permission('edit-zone')) {
            $table->addRowOperation("Edit", $route, '<i class="fa-solid fa-plus"></i>');
        // }

        // if (!cms_check_permission("delete-zone")) {
        //     $table->disableDelete();
        // }
        $table = $table->get();

        return view('pages.branch-items', ['table' => $table, 'branch' => $branch]);

    }

    public function createItem($branch_id)
    {


        $branch = Branch::whereNull('deleted_at')->where('id', $branch_id)->firstOrFail();

        return view('pages.branch-item-create', ['branch' => $branch, 'item_id' => null]);
    }

    public function editItem($branch_id,$item_id)
    {
        

        $branch = Branch::whereNull('deleted_at')->where('id', $branch_id)->firstOrFail();


    
        return view('pages.branch-item-create', ['branch' => $branch, 'item_id' => $item_id]);

        // $branch = Branch::whereNull('deleted_at')->where('id', $branch_id)->firstOrFail();

        // return view('pages.branch-item-create', ['branch' => $branch]);
    }
}
