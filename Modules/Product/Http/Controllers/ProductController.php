<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('product::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::admin.form');
    }

    /**
     * @param ProductRequest $productRequest
     * @return $this
     */
    public function store(ProductRequest $productRequest)
    {
        $product = Product::create($productRequest->validated());
        return redirect()->route('admin.product.edit', $product->slug)->with('success', 'Успешно сохранено!');
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('product::admin.form', compact('product'));
    }

    /**
     * @param ProductRequest $productRequest
     * @param Product $product
     * @return $this
     */
    public function update(ProductRequest $productRequest, Product $product)
    {
        $product->update($productRequest->validated());
        return redirect()->route('admin.product.edit', $product->slug)->with('success', 'Успешно сохранено!');
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return \response()->json(['message' => 'Успешно удалено!']);
    }

    /**
     * @return mixed
     */
    public function datatable()
    {
        return datatables()->of(Product::query())
            ->editColumn('actions', function (Product $product) {
                return view('admin::parts.datatable.actions', [
                    'edit' => [
                        'route' => route('admin.product.edit', $product->slug)
                    ],
                    'delete' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'route' => route('admin.product.destroy', $product->slug)
                    ]
                ]);
            })
            ->editColumn('is_active', function (Product $product) {
                return view('admin::parts.datatable.toggle', [
                    'route' => route('admin.product.toggle_is_active', $product->slug),
                    'id'    => $product->id,
                    'check' => $product->is_active
                ]);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return \response()->json(['message' => 'Успешно изменено!']);
    }
}
