<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Lista de produtos.
     *
     * Lista os produtos de forma paginada, com filtro por nome, com o parametro via queryString:
     * - search: string
     */
    public function index()
    {
        $query = Product::query()->orderBy('name');

        if ($search = request('search')) {
            $query->where('name', 'like', "%$search%");
        }

        $products = $query->paginate(10);

        return response()->json(ProductResource::collection($products)->resource);
    }

    /**
     * Adiciona um novo produto ao banco de dados.
     *
     * @param  \App\Http\Requests\Products\ProductStoreRequest  $request
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return response()->json(new ProductResource($product), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe um produto específico.
     *
     * @param  \App\Models\Product  $product
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product));
    }

    /**
     * Atualiza um produto específico.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());

            return response()->json(new ProductResource($product));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Exclui um produto específico.
     *
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json(['message' => 'Product deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
