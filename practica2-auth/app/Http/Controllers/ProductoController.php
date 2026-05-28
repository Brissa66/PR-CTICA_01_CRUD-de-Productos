<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Producto::query()->latest()->get(), 200);
    }

    public function show(string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json($producto, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $producto = Producto::create($data);

        return response()->json([
            'message' => 'Producto creado correctamente.',
            'producto' => $producto,
        ], 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $producto->update($data);

        return response()->json([
            'message' => 'Producto actualizado correctamente.',
            'producto' => $producto->fresh(),
        ], 200);
    }

    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        $producto->delete();

        return response()->noContent();
    }
}
