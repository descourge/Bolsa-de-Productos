<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Document
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('documents.store') }}"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    <div>
                        <label
                            for="contract_name"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Contract Name
                        </label>

                        <input
                            id="contract_name"
                            type="text"
                            name="contract_name"
                            value="{{ old('contract_name') }}"
                            class="mt-1 block max-w-lg w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    <div>
                        <label
                            for="pdf"
                            class="block text-sm font-medium text-gray-700"
                        >
                            PDF Document
                        </label>

                        <input
                            id="pdf"
                            type="file"
                            name="pdf"
                            accept=".pdf"
                            class="mt-1 block max-w-lg w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    <div>
                        <label
                            for="watermark"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Watermark Image
                        </label>

                        <input
                            id="watermark"
                            type="file"
                            name="watermark"
                            accept=".png,.jpg,.jpeg"
                            class="mt-1 block max-w-lg w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-2">

    <a
        href="{{ route('documents.index') }}"
        class="
            inline-flex
            items-center
            justify-center
            px-3
            py-2
            text-sm
            font-medium
            rounded-md
            bg-gray-100
            text-gray-700
            hover:bg-gray-200
            transition
        "
    >
        Cancel
    </a>

<button
    type="submit"
    style="
        background-color: #4f46e5;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    "
>
    Process Document
</button>

</div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>