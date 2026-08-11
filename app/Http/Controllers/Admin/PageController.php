<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::withCount('contents')->latest()->paginate(10);

        return view('pages.admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('pages.admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePage($request);

        DB::transaction(function () use ($validated) {
            $page = Page::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['slug']),
            ]);

            $this->syncContents($page, $validated['contents'] ?? []);
        });

        return redirect()->route('admin.pages.index')
            ->with('success_title', 'Halaman berhasil disimpan')
            ->with('success', 'Halaman baru dan kontennya berhasil ditambahkan.');
    }

    public function edit(Page $page)
    {
        $page->load('contents');

        return view('pages.admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $this->validatePage($request, $page);

        DB::transaction(function () use ($page, $validated) {
            $page->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['slug']),
            ]);

            $this->syncContents($page, $validated['contents'] ?? []);
        });

        return redirect()->route('admin.pages.index')
            ->with('success_title', 'Halaman berhasil diperbarui')
            ->with('success', 'Perubahan halaman dan kontennya berhasil disimpan.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success_title', 'Halaman berhasil dihapus')
            ->with('success', 'Halaman berhasil dihapus dari daftar.');
    }

    private function validatePage(Request $request, ?Page $page = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug', $request->input('name', ''))),
        ]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'contents' => ['nullable', 'array'],
            'contents.*.section' => ['required', 'string', 'max:255'],
            'contents.*.key' => ['required', 'string', 'max:255'],
            'contents.*.value' => ['nullable', 'string'],
            'contents.*.type' => ['required', 'string', Rule::in(['text', 'textarea', 'html', 'image'])],
        ]);
    }

    private function syncContents(Page $page, array $contents): void
    {
        $page->contents()->delete();

        $page->contents()->createMany(
            collect($contents)
                ->filter(fn (array $content) => filled($content['section'] ?? null) && filled($content['key'] ?? null))
                ->map(fn (array $content) => [
                    'section' => $content['section'],
                    'key' => $content['key'],
                    'value' => $content['value'] ?? null,
                    'type' => $content['type'] ?? 'text',
                ])
                ->unique(fn (array $content) => $content['section'].'|'.$content['key'])
                ->values()->all()
        );
    }
}
