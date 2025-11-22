<x-app-layout>
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#613bf1] mb-4">Edit Item</h2>
        <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')
            @component('admin.components.alert')
            @endcomponent

            <input type="hidden" name="page" value="{{ request()->page }}">
            <div>
                <label class="block text-sm font-medium text-[#000]">Name</label>
                <input type="text" name="name" value="{{ $subcategory->name }}" placeholder="Name"
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Type</label>
                <div class="flex gap-4">
                    @foreach ($types as $type)
                        <label class="flex items-center gap-2">
                            <input class="text-[#613bf1] type-radio" type="radio" name="type_id" value="{{ $type->id }}"
                                {{ $subcategory->type_id == $type->id ? 'checked' : '' }}>
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
                            style="{{ $subcategory->type_id != $cat->type_id ? 'display:none;' : '' }}">
                            <input class="text-[#613bf1]" type="radio" name="category_id" value="{{ $cat->id }}"
                                {{ $subcategory->category_id == $cat->id ? 'checked' : '' }}>
                            {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('subcategory.index') }}"
                    class="border border-[#613bf1] hover:bg-[#613bf1] hover:text-white px-6 py-1 rounded">Back</a>
                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">Update</button>
            </div>
        </form>
    </div>

    <script>

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
