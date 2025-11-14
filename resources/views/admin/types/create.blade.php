<form action="{{ route('type.store') }}" method="POST">
    @component('admin.components.alert')
    @endcomponent
    @csrf
    <el-dialog>
        <dialog id="createType" aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 id="dialog-title" class="text-[20px] font-semibold text-[#000]">Create Type</h3>
                                <div class="mt-2">
                                    <label for="type" class="block text-sm font-medium text-[#000]">Type</label>
                                    <input type="text" name="type" id="type"
                                        class="mt-1 block w-full p-2 border border-[#000] rounded-md text-[#000] text-sm">
                                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700/25 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" command="close" commandfor="dialog"
                            class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white sm:ml-3 sm:w-auto">Submit</button>
                        <button type="button" command="close" commandfor="createType"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-black px-3 py-2 text-sm font-semibold text-white sm:mt-0 sm:w-auto">Cancel</button>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
</form>
