<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('sections')->latest()->paginate(10);
        return view('admin.page.index', compact('pages'));
    }
    public function showBySlug($slug)
    {
        $types = Type::all();

        $page = Page::where('slug', $slug)->with('sections.blocks.position')->firstOrFail();

        return view('client.page.index', compact('page', 'types'));
    }
    public function create()
    {
        $sections = Section::all(); // để chọn section gắn vào page

        return view('admin.page.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'sections' => 'nullable|array', // danh sách section_id
        ]);

        $page = Page::create([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'css' => $request->css ?? '',
            'script' => $request->script ?? '',
            'status' => true,
        ]);

        if ($request->filled('sections')) {
            foreach ($request->sections as $index => $section_id) {
                $page->sections()->attach($section_id, ['order' => $index]);
            }
        }

        return redirect()->back()->with('success', 'Trang đã được tạo.');
    }
}
