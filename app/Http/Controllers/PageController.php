<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function create()
    {
        $sections = Section::all(); // để chọn section gắn vào page

        return view('admin.page.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:page,slug',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'sections' => 'nullable|array', // danh sách section_id
        ]);

        $page = Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => true,
        ]);

        if ($request->filled('sections')) {
            foreach ($request->sections as $index => $section_id) {
                $page->sections()->attach($section_id, ['order' => $index]);
            }
        }

        return redirect()->route('page')->with('success', 'Trang đã được tạo.');
    }
}
