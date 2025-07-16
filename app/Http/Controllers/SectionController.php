<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function create()
    {
        return view('admin.section.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sections,slug',
            'blocks.*.title' => 'required|string|max:255',
            'blocks.*.type' => 'required|string',
            'blocks.*.content' => 'nullable|string',
        ]);

        $section = Section::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('blocks')) {
            foreach ($request->blocks as $index => $blockData) {
                $block = Block::create([
                    'title' => $blockData['title'],
                    'type' => $blockData['type'],
                    'content' => $blockData['content'] ?? '',
                    'status' => true,
                ]);

                // gán block vào section thông qua position
                $section->positions()->create([
                    'name' => "Block $index",
                    'code' => "block_" . $index . "_" . time(),
                    'row' => 1,
                    'col' => $index + 1,
                    'width' => 12,
                ])->blocks()->attach($block->id, ['order' => $index]);
            }
        }

        return redirect()->route('section.create')->with('success', 'Tạo section thành công!');
    }
}
