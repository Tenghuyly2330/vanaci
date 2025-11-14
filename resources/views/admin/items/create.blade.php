<x-app-layout>
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#613bf1] mb-4">Create Item</h2>
        <form action="{{ route('item_backend.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @component('admin.components.alert')
            @endcomponent

            {{-- =============== BASIC INFO =============== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#000]">Name</label>
                    <input type="text" name="name" class="mt-1 block w-full p-2 border rounded-md text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#000]">Price</label>
                    <input type="number" step="0.01" name="price"
                        class="mt-1 block w-full p-2 border rounded-md text-sm" min="0">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#000]">Discount (Optional (%))</label>
                    <input type="number" name="discount" class="mt-1 block w-full p-2 border rounded-md text-sm"
                        min="0" max="100">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full p-2 border rounded-md text-[#000] text-[10px]">{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            {{-- =============== STATUS =============== --}}
            <div class="flex items-center gap-2">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" id="status_new"
                    class="form-checkbox text-[#613bf1]">
                <label for="status_new" class="text-sm font-medium text-gray-700">New</label>
            </div>


            {{-- =============== DYNAMIC SIZES =============== --}}
            <div>
                <label class="block text-sm font-medium text-[#000]">Sizes</label>
                <div id="sizesWrapper" class="space-y-2"></div>
                <button type="button" id="addSizeBtn" class="bg-[#613bf1] text-white px-3 py-1 rounded-md mt-2">+ Add
                    Size</button>
            </div>

            {{-- =============== DYNAMIC COLORS (WITH IMAGE PREVIEW) =============== --}}
            <div>
                <label class="block text-sm font-medium text-[#000]">Colors</label>
                <div id="colorsWrapper" class="space-y-4"></div>
                <button type="button" id="addColorBtn" class="bg-[#613bf1] text-white px-3 py-1 rounded-md mt-2">+ Add
                    Color</button>
            </div>

            {{-- =============== TYPE SELECTION =============== --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <div id="type_group" class="flex flex-wrap gap-4">
                    @foreach ($types as $type)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="type_id" value="{{ $type->id }}"
                                class="form-radio text-[#613bf1] type-radio">
                            <span class="text-gray-800">{{ $type->type }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- =============== CATEGORY FILTERED BY TYPE =============== --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <div id="category_group" class="flex flex-wrap gap-4">
                    @foreach ($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer category-item"
                            data-type-id="{{ $category->type_id }}">
                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                class="form-radio text-[#613bf1]">
                            <span class="text-gray-800">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- =============== SUBMIT ACTIONS =============== --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('item_backend.index') }}"
                    class="border border-[#613bf1] hover:bg-[#613bf1] hover:text-white px-6 py-1 rounded">Back</a>
                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">Submit</button>
            </div>
        </form>
    </div>

    {{-- ================= JAVASCRIPT ================= --}}
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

        // ---------------- SIZES ----------------
        document.getElementById('addSizeBtn').addEventListener('click', () => {
            const wrapper = document.getElementById('sizesWrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-2');
            div.innerHTML = `
                <input type="text" name="sizes[]" placeholder="e.g., M" class="border rounded p-1 text-sm w-40">
                <button type="button" class="text-red-600" onclick="this.parentElement.remove()">✕</button>`;
            wrapper.appendChild(div);
        });

        // ---------------- COLORS ----------------
        document.getElementById('addColorBtn').addEventListener('click', () => {
            const index = document.querySelectorAll('.color-block').length;
            const wrapper = document.getElementById('colorsWrapper');

            const div = document.createElement('div');
            div.classList.add('color-block', 'border', 'p-3', 'rounded-md');
            div.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-[#000]">Color #${index + 1}</h4>
                    <button type="button" class="text-red-600 text-sm" onclick="this.closest('.color-block').remove()">✕</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="colors[${index}][name]" placeholder="Color name"
                        class="border rounded p-2 text-sm">
                    <input type="color" name="colors[${index}][code]" class="border rounded p-1 w-16 h-10">
                    <input type="file" name="colors[${index}][images][]" multiple accept="image/*"
                        class="block border rounded p-1 text-sm color-image-input"
                        data-index="${index}">
                </div>

                <div id="color-preview-${index}"
                    class="flex flex-wrap gap-2 mt-3 bg-gray-50 p-2 rounded-md min-h-[50px] justify-start items-start">
                    <p class="text-gray-400 text-sm">No images selected.</p>
                </div>
            `;
            wrapper.appendChild(div);
        });

        // ---------------- COLOR IMAGE PREVIEW & REMOVE ----------------
        document.addEventListener('change', (event) => {
            if (event.target.classList.contains('color-image-input')) {
                const input = event.target;
                const index = input.dataset.index;
                const preview = document.getElementById(`color-preview-${index}`);
                const files = Array.from(input.files);

                if (files.length === 0) {
                    preview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
                    return;
                }

                preview.innerHTML = '';

                files.forEach((file, i) => {
                    const imgURL = URL.createObjectURL(file);
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative w-24 h-24 border rounded overflow-hidden';

                    const img = document.createElement('img');
                    img.src = imgURL;
                    img.className = 'w-full h-full object-cover';

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '✕';
                    btn.className =
                        'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center hover:bg-red-700';
                    btn.onclick = () => {
                        files.splice(i, 1);
                        updateColorInputFiles(input, files);
                        wrapper.remove();
                        if (files.length === 0) {
                            preview.innerHTML =
                                '<p class="text-gray-400 text-sm">No images selected.</p>';
                        }
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                });
            }
        });

        function updateColorInputFiles(input, files) {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        // ---------------- TYPE → CATEGORY FILTER ----------------
        const typeRadios = document.querySelectorAll('.type-radio');
        const categoryItems = document.querySelectorAll('.category-item');

        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedTypeId = this.value;
                categoryItems.forEach(item => {
                    if (item.dataset.typeId === selectedTypeId) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                        item.querySelector('input[type="radio"]').checked = false;
                    }
                });
            });
        });

        // Hide all categories initially
        categoryItems.forEach(item => item.style.display = 'none');
    </script>
</x-app-layout>
