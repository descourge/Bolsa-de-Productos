<?php

namespace App\Http\Controllers;

use App\Services\PdfWatermarkService;
use App\Models\Document;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(
        private PdfWatermarkService $pdfService
    ) {
    }

    public function create()
    {
        return view('documents.create');
    }

    public function index()
    {
        $documents = Document::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'documents.index',
            compact('documents')
        );
    }

public function store(StoreDocumentRequest $request)
{
    $pdfFile = $request->file('pdf');

    $watermarkFile = $request->file('watermark');

    $response = $this->pdfService->process(
        $pdfFile->getRealPath(),
        $watermarkFile->getRealPath()
    );


    if (! $response->successful()) {
        return back()->withErrors([
            'error' => 'PDF processing failed'
        ]);
    }

    $filename = uniqid() . '.pdf';

    Storage::put(
        'contracts/' . $filename,
        $response->body()
    );

    Document::create([
        'user_id' => auth()->id(),

        'contract_name' => $request->contract_name,

        'original_filename' =>
            $pdfFile->getClientOriginalName(),

        'stored_filename' =>
            'contracts/' . $filename,

        'file_size' =>
            strlen($response->body()),

        'status' =>
            'processed',
    ]);

    return redirect()
        ->route('documents.index')
        ->with(
            'success',
            'Document created successfully'
        );
}

public function download(
    Document $document
)
{
    abort_unless(
        $document->user_id === auth()->id(),
        403
    );

    return Storage::download(
        $document->stored_filename
    );
}
}