<x-app-layout>
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#613bf1] mb-4">Edit Item</h2>
        <form action="{{ route('item_backend.update', $item_backend->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6" id="itemEditForm">
            @csrf
            @method('PUT')
            @component('admin.components.alert')
            @endcomponent

            <input type="hidden" name="page" value="{{ request()->page }}">
            {{-- Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#000]">Name</label>
                    <input type="text" name="name" value="{{ $item_backend->name }}" placeholder="Name"
                        class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#000]">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $item_backend->price }}"
                        min="0" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#000]">Discount (Optional (%))</label>
                    <input type="number" name="discount" value="{{ $item_backend->discount }}" min="0"
                        max="100" class="w-full border p-2 rounded">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-[#000]">Description</label>
                <textarea name="description" id="description" rows="6"
                    class="mt-1 block w-full p-2 border rounded-md text-black text-[10px]">{{ old('description', $item_backend->description) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            {{-- Status --}}
            <div class="flex flex-col gap-2">
                <label for="" class="text-sm font-medium text-[#000]">Status (Optional)</label>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" id="status_new"
                        class="form-checkbox text-[#613bf1]" {{ $item_backend->status ? 'checked' : '' }}>
                    <label for="status_new" class="text-sm font-medium text-gray-700">New</label>
                </div>
            </div>

            {{-- Sizes --}}
            <div>
                <label>Sizes</label>
                <div id="sizesWrapper" class="space-y-2">
                    @foreach ($item_backend->size as $sz)
                        <div class="flex gap-2">
                            <input type="text" name="sizes[]" value="{{ $sz }}"
                                class="border p-1 rounded w-40">
                            <button type="button" class="text-red-600" onclick="this.parentElement.remove()">✕</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addSizeBtn" class="bg-[#613bf1] text-white px-3 py-1 rounded mt-2">
                    + Add Size
                </button>
            </div>

            {{-- Colors --}}
            <div>
                <label>Colors</label>
                <div id="colorsWrapper" class="space-y-4">
                    @foreach ($item_backend->color as $i => $col)
                        <div class="color-block border p-3 rounded-md">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold">Color #{{ $i + 1 }}</h4>
                                <button type="button" class="text-red-600 text-sm remove-color">✕</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <input type="text" name="colors[{{ $i }}][name]"
                                    value="{{ $col['name'] }}" placeholder="Color name" class="border p-2 rounded">
                                <input type="color" name="colors[{{ $i }}][code]"
                                    value="{{ $col['code'] }}" class="border rounded p-1 w-16 h-10">
                                <input type="file" name="colors[{{ $i }}][images][]" multiple
                                    class="color-image-input" data-index="{{ $i }}">
                            </div>

                            {{-- Existing image preview --}}
                            <div id="color-preview-{{ $i }}"
                                class="flex flex-wrap gap-2 mt-3 bg-gray-50 p-2 rounded min-h-[50px]">
                                @if (!empty($col['images']))
                                    @foreach ($col['images'] as $img)
                                        <div class="relative w-24 h-24 border rounded overflow-hidden">
                                            <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                                            <button type="button"
                                                class="absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center hover:bg-red-700 remove-existing"
                                                data-path="{{ $img }}">✕</button>
                                            <input type="hidden" name="colors[{{ $i }}][existing_images][]"
                                                value="{{ $img }}">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-400 text-sm">No images selected.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="addColorBtn" class="bg-[#613bf1] text-white px-3 py-1 rounded mt-2">
                    + Add Color
                </button>
            </div>

            {{-- Type / Category --}}
            <div>
                <label>Type</label>
                <div class="flex gap-4">
                    @foreach ($types as $type)
                        <label class="flex items-center gap-2">
                            <input class="text-[#613bf1]" type="radio" name="type_id" value="{{ $type->id }}" class="type-radio"
                                {{ $item_backend->type_id == $type->id ? 'checked' : '' }}>
                            {{ $type->type }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label>Category</label>
                <div id="category_group" class="flex flex-wrap gap-4">
                    @foreach ($categories as $cat)
                        <label class="flex items-center gap-2 category-item" data-type-id="{{ $cat->type_id }}"
                            style="{{ $item_backend->type_id != $cat->type_id ? 'display:none;' : '' }}">
                            <input class="text-[#613bf1]" type="radio" name="category_id" value="{{ $cat->id }}"
                                {{ $item_backend->category_id == $cat->id ? 'checked' : '' }}>
                            {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('item_backend.index') }}"
                    class="border border-[#613bf1] hover:bg-[#613bf1] hover:text-white px-6 py-1 rounded">Back</a>
                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">Update</button>
            </div>
        </form>
    </div>

    {{-- ✅ CLEANED & FIXED JS --}}
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'undo', 'redo', 'code', 'codeBlock'
                ],
                removePlugins: ['Heading']
            })
            .catch(error => {
                console.error(error);
            });

        // Add size
        document.getElementById('addSizeBtn').addEventListener('click', () => {
            const wrapper = document.getElementById('sizesWrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2');
            div.innerHTML = `
                <input type="text" name="sizes[]" placeholder="e.g., M" class="border p-1 rounded w-40">
                <button type="button" class="text-red-600" onclick="this.parentElement.remove()">✕</button>
            `;
            wrapper.appendChild(div);
        });

        // Add color
        document.getElementById('addColorBtn').addEventListener('click', () => {
            const index = document.querySelectorAll('.color-block').length;
            const wrapper = document.getElementById('colorsWrapper');
            const div = document.createElement('div');
            div.classList.add('color-block', 'border', 'p-3', 'rounded-md');
            div.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-[#000]">Color #${index + 1}</h4>
                    <button type="button" class="text-red-600 text-sm remove-color">✕</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="colors[${index}][name]" placeholder="Color name" class="border p-2 rounded text-sm">
                    <input type="color" name="colors[${index}][code]" class="border rounded p-1 w-16 h-10">
                    <input type="file" name="colors[${index}][images][]" multiple class="color-image-input" data-index="${index}">
                </div>
                <div id="color-preview-${index}" class="flex flex-wrap gap-2 mt-3 bg-gray-50 p-2 rounded min-h-[50px]">
                    <p class="text-gray-400 text-sm">No images selected.</p>
                </div>
            `;
            wrapper.appendChild(div);
        });

        // Preview selected new color images
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('color-image-input')) {
                const input = event.target;
                const index = input.dataset.index;
                const preview = document.getElementById(`color-preview-${index}`);
                const files = Array.from(input.files);
                preview.innerHTML = files.length ? '' : '<p class="text-gray-400 text-sm">No images selected.</p>';

                files.forEach((file, i) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative w-24 h-24 border rounded overflow-hidden';
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'w-full h-full object-cover';

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '✕';
                    btn.className =
                        'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center hover:bg-red-700';
                    btn.onclick = () => {
                        files.splice(i, 1);
                        const dt = new DataTransfer();
                        files.forEach(f => dt.items.add(f));
                        input.files = dt.files;
                        wrapper.remove();
                        if (files.length === 0)
                            preview.innerHTML =
                            '<p class="text-gray-400 text-sm">No images selected.</p>';
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                });
            }
        });

        // Handle deleting existing images & entire color blocks
        document.addEventListener('click', function(e) {
            const form = document.getElementById('itemEditForm');

            // 🧹 Remove single existing image
            if (e.target.classList.contains('remove-existing')) {
                const btn = e.target;
                const path = btn.dataset.path;

                // Remove the preview + its hidden input
                btn.closest('.relative').remove();
                form.querySelectorAll(`input[value="${path}"]`).forEach(h => h.remove());

                // Add a hidden deleted_images input
                const deletedInput = document.createElement('input');
                deletedInput.type = 'hidden';
                deletedInput.name = 'deleted_images[]';
                deletedInput.value = path;
                form.appendChild(deletedInput);
            }

            // 🧹 Remove entire color block (and mark its images as deleted)
            if (e.target.classList.contains('remove-color')) {
                const block = e.target.closest('.color-block');

                block.querySelectorAll('input[name*="existing_images"]').forEach(h => {
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_images[]';
                    deletedInput.value = h.value;
                    form.appendChild(deletedInput);
                });

                block.remove();
            }
        });

        document.querySelectorAll('.type-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedType = this.value;

                document.querySelectorAll('#category_group .category-item').forEach(item => {
                    const typeId = item.dataset.typeId;

                    // Show categories belonging to selected type
                    if (typeId == selectedType) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                        item.querySelector('input').checked = false; // uncheck invalid category
                    }
                });
            });
        });
    </script>
</x-app-layout>
