<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()->orderBy('id')->get();

        return $this->successResponse('Produtos listados com sucesso.', $products, 200);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::query()->create($request->validated());

        return $this->successResponse('Produto criado com sucesso.', $product, 201);
    }

    public function show(int $product): JsonResponse
    {
        $foundProduct = $this->findProduct($product);

        if ($foundProduct === null) {
            return $this->errorResponse('Produto nao encontrado.', 404);
        }

        return $this->successResponse('Produto encontrado com sucesso.', $foundProduct, 200);
    }

    public function update(UpdateProductRequest $request, int $product): JsonResponse
    {
        $foundProduct = $this->findProduct($product);

        if ($foundProduct === null) {
            return $this->errorResponse('Produto nao encontrado.', 404);
        }

        $foundProduct->update($request->validated());

        return $this->successResponse('Produto atualizado com sucesso.', $foundProduct->fresh(), 200);
    }

    public function destroy(int $product): JsonResponse
    {
        $foundProduct = $this->findProduct($product);

        if ($foundProduct === null) {
            return $this->errorResponse('Produto nao encontrado.', 404);
        }

        $foundProduct->delete();

        return $this->successResponse('Produto removido com sucesso.', ['id' => $product], 200);
    }

    /**
     * @param mixed $data
     */
    private function successResponse(string $message, $data, int $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    private function errorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => null,
        ], $statusCode);
    }

    private function findProduct(int $id): ?Product
    {
        return Product::query()->find($id);
    }
}
