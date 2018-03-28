<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class DocumentController extends Controller
{

    private $perPage=20;

    public function index()
    {
        return Document::paginate($this->perPage);
    }

    public function show(Document $document)
    {
        return $document;
    }

    /**
     * Creates thumbnail from a PDF file and returns its path
     *
     * @param string $path
     * @param int $width
     * @param int $height
     * @return string
     */
    private function createThumbnail($path, $width, $height)
    {
        $thumbPath = 'thumbs/' . \File::name($path) . '_thumb.png';
        $imagick = new \Imagick(storage_path('app/' . $path) . '[0]');
        $imagick->setImageFormat('png');
        $imagick->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
        $imagick->writeImage(storage_path('app/' . $thumbPath));
        return $thumbPath;
    }

    public function store(Request $request)
    {
        if ($request->hasFile('document')) {
            if ($request->file('document')->isValid()) {

                $name = $request->file('document')->getClientOriginalName();
                //save document
                $path = $request->file('document')->store('documents');
                //create thumbnail
                $thumbPath = $this->createThumbnail($path, 300, 300);
                $document = Document::create(['name' => $name, 'path' => $path, 'thumbnailPath' => $thumbPath]);
                return response()->json($document, 201);
            }
        }
        return response()->json(['error' => 'upload failed'], 422);
    }

    public function showAttachment(Document $document)
    {
        return response()->file(storage_path('app/' . $document->path), ['Content-Type' => 'application/pdf']);
    }

    public function showPreview(Document $document)
    {
        return response()->file(storage_path('app/' . $document->thumbnailPath), ['Content-Type' => 'image/png']);
    }

}
