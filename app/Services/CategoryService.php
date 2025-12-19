<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public static function store(array $data): Category
    {

        $category = Category::create($data['category']);
        ImageService::storeBatch($category, $data['images']);
        return $category;
    }

    public static function update(Category $category, array $data): Category
    {

        $category->update($data['category']);
        ImageService::storeBatch($category, $data['images']);
        return $category->fresh();
    }


    public static function breadcrumbs(Category $category): array
    {
        $breadcrumbs =[];
        while ($category->parent_id){

            $category = Category::find($category->parent_id);
            $breadcrumbs[] = [
                'id' => $category->id,
                'title' => $category->title,
                'parent_id' => $category->parent_id,
            ];
        }
        return array_reverse($breadcrumbs);
    }

    public static function delete(Category $category)
    {
        $images = $category->images;
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
        }

        foreach ($images as $image) {
            ImageService::destroy($image);
        }

    }

    public static function getCategoryChildren(Category $category)
    {
        $collection = collect([]);
        $categoryChildren = Category::where('parent_id', $category->id)->get();
        foreach ($categoryChildren as $categoryChild) {
            $collection = $collection->merge(self::getCategoryChildren($categoryChild));
        }
        $collection->push($category);
        return $collection;
    }

    public static function getCategoryParents(Category $category)
    {
        $collection = collect([]);
        if ($category->parent_id) {
            $patentCategory = Category::find($category->parent_id);
            $collection->push($patentCategory);
            $collection = $collection->merge(self::getCategoryParents($patentCategory));
        }
        return $collection->reverse();
    }




}
