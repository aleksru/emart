<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Repository\CategoryRepository;
use Nwidart\Modules\Facades\Module;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = (new CategoryRepository())->buildTree();
        return view('category::admin.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('category::admin.form');
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $categoryRequest)
    {
        $category = Category::create($categoryRequest->validated());

        return redirect()->route('admin.category.edit', $category->slug)->with('success', 'Успешно сохранено!');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('category::admin.form', compact('category'));
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $categoryRequest, Category $category)
    {
        $category->update($categoryRequest->validated());
        return redirect()->route('admin.category.edit', $category->slug)->with('success', 'Успешно сохранено!');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return \response()->json(['message' => 'Успешно удалено!']);
    }

    /**
     * @return mixed
     */
    public function datatable()
    {
        return datatables()->of(Category::query()->withTrashed())
            ->editColumn('actions', function (Category $category) {
                return view('admin::parts.datatable.actions', [
                    'edit' => [
                        'route' => route('admin.category.edit', $category->slug)
                    ],
                    'delete' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'route' => route('admin.category.destroy', $category->slug)
                    ]
                ]);
            })
            ->editColumn('is_active', function (Category $category) {
                return view('admin::parts.datatable.toggle', [
                    'route' => route('admin.category.toggle_is_active', $category->slug),
                    'id'    => $category->id,
                    'check' => $category->is_active
                ]);
            })
            ->editColumn('deleted_at', function (Category $category) {
                return view('admin::parts.datatable.toggle', [
                    'route' => route('admin.category.toggle_deleted_at', ['id' => $category->id]),
                    'id'    => $category->id,
                    'check' => $category->deleted_at
                ]);
            })
            ->editColumn('parent_id', function (Category $category) {
                return $category->parent ? $category->parent->name : 'Корневая';
            })
            ->rawColumns(['actions', 'deleted_at'])
            ->make(true);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();

        return \response()->json(['message' => 'Успешно изменено!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleDeletedAt(Request $request)
    {
        if(!$category = Category::withTrashed()->find($request->get('id'))){
            return \response()->json(['error' => 'Не найден ID!']);
        }
        if(!$category->deleted_at){
            return \response()->json(['error' => 'Категория не удалена!']);
        }
        $category->restore();

        return \response()->json(['message' => 'Успешно изменено!']);
    }
}
