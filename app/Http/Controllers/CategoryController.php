<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Import model Category

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách các danh mục.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị form để tạo mới danh mục.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Lưu danh mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'entry_date' => 'required|date',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Danh mục đã được tạo thành công.');
    }

    /**

     * Hiển thị form để chỉnh sửa một danh mục.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Cập nhật thông tin của một danh mục trong cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'entry_date' => 'nullable|date',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    /**
     * Xoá một danh mục khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Danh mục đã được xoá thành công.');
    }
}
