<div class="card p-4 mb-3 border position-relative" id="block-{{ $index }}">
    <button style="top:10px; right:10px;" type="button" class="btn-close position-absolute"
        onclick="this.parentElement.remove()"></button>

    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Tiêu đề Block</label>
            <input type="text" name="blocks[{{ $index }}][title]" class="form-control"
                value="{{ $block->title }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Loại Block</label>
            <select name="blocks[{{ $index }}][type]" class="form-select">
                <option value="html" {{ $block->type == 'html' ? 'selected' : '' }}>HTML</option>
                <option value="text" {{ $block->type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="image" {{ $block->type == 'image' ? 'selected' : '' }}>Image</option>
            </select>
        </div>
    </div>

    <div class="mb-2">
        <label class="form-label">Nội dung</label>
        <textarea name="blocks[{{ $index }}][content]" class="form-control" rows="3">{{ $block->content }}</textarea>
    </div>

    <div class="mb-2">
        <label class="form-label">Chọn vị trí</label>
        <select name="blocks[{{ $index }}][position_mode]" class="form-select"
            onchange="toggleCustom({{ $index }}, this)">
            <option value="default">-- Chọn vị trí có sẵn --</option>
            <option value="custom" {{ $block->position_id === null ? 'selected' : '' }}>+ Tùy chỉnh vị trí</option>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}" {{ $block->position_id == $position->id ? 'selected' : '' }}>
                    {{ $position->name }} ({{ $position->code }})
                </option>
            @endforeach
        </select>
        <input type="hidden" name="blocks[{{ $index }}][position_id]"
            id="block-{{ $index }}-position-id" value="{{ $block->position_id }}">
    </div>

    <div class="row g-3 custom-position " id="block-{{ $index }}-custom">
        <div class="col-md-3"><label class="form-label">Vị trí hàng</label>
            <input type="number" name="blocks[{{ $index }}][row]" class="form-control"
                value="{{ $block->position->row }}">
        </div>
        <div class="col-md-3"><label class="form-label">Vị trí cột</label>
            <input type="number" name="blocks[{{ $index }}][col]" class="form-control"
                value="{{ $block->position->col }}">
        </div>
        <div class="col-md-3"><label class="form-label">Căn chỉnh</label>
            <select class="form-select" name="blocks[{{ $index }}][align]">
                <option value="left" {{ $block->position->align == 'left' ? 'selected' : '' }}>Trái</option>
                <option value="center" {{ $block->position->align == 'center' ? 'selected' : '' }}>Giữa</option>
                <option value="right" {{ $block->position->align == 'right' ? 'selected' : '' }}>Phải</option>
            </select>
        </div>
        <div class="col-md-3"><label class="form-label">Class Style</label>
            <input type="text" name="blocks[{{ $index }}][class]" class="form-control"
                value="{{ $block->position->class }}">
        </div>
        <div class="col-md-3"><label class="form-label">Width</label>
            <input type="number" name="blocks[{{ $index }}][width]" class="form-control"
                value="{{ $block->position->width ?? 12 }}">
        </div>
        <div class="col-md-3"><label class="form-label">Width SM</label>
            <input type="number" name="blocks[{{ $index }}][width_sm]" class="form-control"
                value="{{ $block->position->width_sm ?? 12 }}">
        </div>
        <div class="col-md-3"><label class="form-label">Width MD</label>
            <input type="number" name="blocks[{{ $index }}][width_md]" class="form-control"
                value="{{ $block->position->width_md ?? 12 }}">
        </div>
        <div class="col-md-3"><label class="form-label">Width LG</label>
            <input type="number" name="blocks[{{ $index }}][width_lg]" class="form-control"
                value="{{ $block->position->width_lg ?? 12 }}">
        </div>
    </div>
</div>
