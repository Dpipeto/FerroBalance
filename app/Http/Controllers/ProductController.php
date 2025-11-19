<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Mostrar listado de productos
    public function index()
    {
        $productos = Product::all();
        return view('productos', compact('productos'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'Name'        => 'required|string|max:255',
            'Description' => 'required|string',
            'Price'       => 'required|numeric',
            'Cost'        => 'required|numeric',
            'Stock'       => 'required|integer',
            'CategoryId'  => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(Product $producto)
    {
        return view('productos_edit', compact('producto'));
    }

    // Actualizar producto
    public function update(Request $request, Product $producto)
    {
        $request->validate([
            'Name'        => 'required|string|max:255',
            'Description' => 'required|string',
            'Price'       => 'required|numeric',
            'Cost'        => 'required|numeric',
            'Stock'       => 'required|integer',
            'CategoryId'  => 'required|integer',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Product $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
