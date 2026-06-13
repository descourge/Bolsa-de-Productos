<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Documents
            </h2>

            <a
                href="{{ route('documents.create') }}"
                style="
                    background-color: #4f46e5;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 6px;
                    text-decoration: none;
                "
            >
                New Document
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    style="
                        background: #dcfce7;
                        color: #166534;
                        padding: 12px;
                        border-radius: 6px;
                        margin-bottom: 16px;
                    "
                >
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">

                <table class="w-full table-fixed">

                    <thead style="background: #f3f4f6;">
    <tr>
        <th class="w-2/5 px-6 py-3 text-left">
            Contract
        </th>

        <th class="w-1/5 px-6 py-3 text-left">
            Status
        </th>

        <th class="w-1/5 px-6 py-3 text-left">
            Created At
        </th>

        <th class="w-1/5 px-6 py-3 text-center">
            Actions
        </th>
    </tr>
</thead>

                    <tbody>

                        @forelse($documents as $document)

                            <tr style="border-top: 1px solid #e5e7eb;">

                                <td class="px-6 py-4">
                                    <div>
                                        <strong>
                                            {{ $document->contract_name }}
                                        </strong>
                                    </div>

                                    <small style="color: gray;">
                                        {{ $document->original_filename }}
                                    </small>
                                </td>

                                <td class="px-6 py-4">
                                    {{ ucfirst($document->status) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $document->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    <a
                                        href="{{ route('documents.download', $document) }}"
                                        style="
                                            background-color: #2563eb;
                                            color: white;
                                            padding: 6px 10px;
                                            border-radius: 6px;
                                            text-decoration: none;
                                        "
                                    >
                                        Download
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="4"
                                    class="px-6 py-6 text-center"
                                >
                                    No documents found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>

        </div>
    </div>
</x-app-layout>