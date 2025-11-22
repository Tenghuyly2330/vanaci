<x-app-layout>
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#613bf1] mb-4">Create SubCategory</h2>
        <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @component('admin.components.alert')
            @endcomponent

            <div>
                <label class="block text-sm font-medium text-[#000]">Name</label>
                <input type="text" name="name" class="mt-1 block w-full p-2 border rounded-md text-sm">
            </div>

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

            <div class="flex justify-between mt-6">
                <a href="{{ route('subcategory.index') }}"
                    class="border border-[#613bf1] hover:bg-[#613bf1] hover:text-white px-6 py-1 rounded">Back</a>
                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">Submit</button>
            </div>
        </form>
    </div>

    <script>
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

        categoryItems.forEach(item => item.style.display = 'none');
    </script>
</x-app-layout>
