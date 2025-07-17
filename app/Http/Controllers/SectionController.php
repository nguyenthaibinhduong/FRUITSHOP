<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Block;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller

{
    public function index()
    {
        $sections = Section::with(['blocks.position'])->latest()->paginate(10);
        return view('admin.section.index', compact('sections'));
    }

    public function indexApi($search)
    {
        $sections = Section::with(['blocks.position'])->where('name', $search);
        return response()->json($sections);
    }
    public function create()
    {
        $positions = Position::where('type', 1)->get();
        return view('admin.section.create', compact('positions'));
    }

    public function store(Request $request)
    {
        // Tạo Section
        $section = Section::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'description' => $request->description,
            'code' =>  Str::slug($request->slug) . '_' . uniqid(),
            'type' => 'block', // hoặc lấy từ form nếu cần
        ]);

        // Lặp qua các blocks
        if ($request->has('blocks')) {
            foreach ($request->blocks as $blockData) {

                // Nếu chọn custom vị trí
                if ($blockData['position_mode'] === 'custom') {
                    // Tạo mới Position
                    $position = Position::create([
                        'name' => $blockData['title'] ?? 'Custom Block',
                        'code' => 'custom_' . uniqid(),
                        'type' => '0',
                        'row' => $blockData['row'] ?? 1,
                        'col' => $blockData['col'] ?? 1,
                        'width' => $blockData['width'] ?? 12,
                        'width_sm' => $blockData['width_sm'] ?? 12,
                        'width_md' => $blockData['width_md'] ?? 12,
                        'width_lg' => $blockData['width_lg'] ?? 12,
                        'align' => $blockData['align'] ?? 'left',
                        'order' => 1,
                    ]);
                } else {
                    // Dùng position có sẵn
                    $position = Position::find($blockData['position_id']);
                }

                // Tạo block
                Block::create([
                    'title' => $blockData['title'],
                    'code' => Str::slug($blockData['title']) . '-' . uniqid(),
                    'type' => $blockData['type'] ?? 'text',
                    'content' => $blockData['content'],
                    'class' => $blockData['class'] ?? '',
                    'section_id' => $section->id,
                    'position_id' => $position->id ?? null,
                    'status' => true,
                ]);
            }
        }

        return redirect()->route('section.create')->with('success', 'Tạo section thành công!');
    }

    public function edit($id)
    {
        $section = Section::with(['blocks.position'])->findOrFail($id);
        $positions = Position::all(); // Các vị trí có sẵn để lựa chọn

        return view('admin.section.edit', compact('section', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        // Cập nhật thông tin section
        $section->update([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'description' => $request->description,
        ]);

        $updatedBlockIds = [];

        // Xử lý blocks
        if ($request->has('blocks')) {
            foreach ($request->blocks as $blockData) {
                // Nếu chọn custom position
                if ($blockData['position_mode'] === 'custom') {
                    $position = Position::create([
                        'name' => $blockData['title'] ?? 'Custom Block',
                        'code' => 'custom_' . uniqid(),
                        'type' => '0',
                        'row' => $blockData['row'] ?? 1,
                        'col' => $blockData['col'] ?? 1,
                        'width' => $blockData['width'] ?? 12,
                        'width_sm' => $blockData['width_sm'] ?? 12,
                        'width_md' => $blockData['width_md'] ?? 12,
                        'width_lg' => $blockData['width_lg'] ?? 12,
                        'align' => $blockData['align'] ?? 'left',
                        'order' => 1,
                    ]);
                } else {
                    $position = Position::find($blockData['position_id']);
                }

                if (isset($blockData['id'])) {
                    // Cập nhật block cũ
                    $block = Block::find($blockData['id']);
                    if ($block) {
                        $block->update([
                            'title' => $blockData['title'],
                            'type' => $blockData['type'] ?? 'text',
                            'content' => $blockData['content'],
                            'class' => $blockData['class'] ?? '',
                            'position_id' => $position->id ?? null,
                            'status' => true,
                        ]);
                        $updatedBlockIds[] = $block->id;
                    }
                } else {
                    // Tạo block mới
                    $newBlock = Block::create([
                        'title' => $blockData['title'],
                        'code' => Str::slug($blockData['title']) . '-' . uniqid(),
                        'type' => $blockData['type'] ?? 'text',
                        'content' => $blockData['content'],
                        'class' => $blockData['class'] ?? '',
                        'section_id' => $section->id,
                        'position_id' => $position->id ?? null,
                        'status' => true,
                    ]);
                    $updatedBlockIds[] = $newBlock->id;
                }
            }
        }

        // Xóa các block không còn tồn tại trong danh sách mới
        $section->blocks()->whereNotIn('id', $updatedBlockIds)->delete();

        return redirect()->route('section')->with('success', 'Cập nhật section thành công!');
    }
}
