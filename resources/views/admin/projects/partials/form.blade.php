<div class="soft-panel overflow-hidden p-1.5 animate-fade-in">
    <div class="rounded-lg p-6 md:p-8 space-y-6" style="background:var(--ink-950);">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Title --}}
            <div>
                <label for="title" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Project Title
                </label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $project->title ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('title')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Slug (URL suffix)
                </label>
                <input
                    id="slug"
                    type="text"
                    name="slug"
                    value="{{ old('slug', $project->slug ?? '') }}"
                    placeholder="e.g. portfolio-cms"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                @error('slug')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Technology --}}
            <div class="md:col-span-2">
                <label for="technology" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Technologies / Capabilities (Comma-separated)
                </label>
                <input
                    id="technology"
                    type="text"
                    name="technology"
                    value="{{ old('technology', $project->technology ?? '') }}"
                    placeholder="e.g. Laravel, Three.js, Tailwind CSS"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                @error('technology')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- GitHub URL --}}
            <div>
                <label for="github_url" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Source Code URL (GitHub)
                </label>
                <input
                    id="github_url"
                    type="url"
                    name="github_url"
                    value="{{ old('github_url', $project->github_url ?? '') }}"
                    placeholder="e.g. https://github.com/..."
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                @error('github_url')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Live URL --}}
            <div>
                <label for="live_url" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Live Production URL
                </label>
                <input
                    id="live_url"
                    type="url"
                    name="live_url"
                    value="{{ old('live_url', $project->live_url ?? '') }}"
                    placeholder="e.g. https://example.com"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                @error('live_url')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label for="description" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Project Description / Specifications
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Describe the build process, role, and results..."
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >{{ old('description', $project->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image Preview --}}
            @if(isset($project))
                <div class="md:col-span-2 rounded border p-4" style="border-color:var(--line); background:var(--ink-900);">
                    <label class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                        Current Preview Image
                    </label>
                    @if($project->image)
                        <img
                            src="{{ asset('storage/'.$project->image) }}"
                            alt="Project Preview"
                            class="w-44 h-28 object-cover rounded border"
                            style="border-color:var(--line-strong);"
                        >
                    @else
                        <p class="text-xs italic" style="color:var(--slate);">No image file uploaded.</p>
                    @endif
                </div>
            @endif

            {{-- Image Upload --}}
            <div class="md:col-span-2">
                <label for="image" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Upload Preview Image
                </label>
                <input
                    id="image"
                    type="file"
                    name="image"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300 file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[.68rem] file:font-mono file:uppercase file:font-semibold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--slate);"
                >
                @error('image')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Featured checkbox --}}
            <div class="md:col-span-2 py-2">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-900 text-[var(--brass)] focus:ring-0 focus:ring-offset-0 h-4.5 w-4.5"
                    >
                    <span class="font-mono text-xs uppercase tracking-wider select-none" style="color:var(--paper-dim);">
                        Pin to Featured Work list on homepage
                    </span>
                </label>
                @error('featured')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="pt-4 border-t flex gap-4" style="border-color:var(--line);">
            <a href="{{ route('admin.projects.index') }}" class="ghost-button rounded px-6 py-3.5 text-xs">
                Cancel
            </a>
            <button
                type="submit"
                class="gradient-button rounded px-6 py-3.5 text-xs font-semibold"
            >
                {{ isset($project) ? 'Update Project Record' : 'Publish Project Record' }}
            </button>
        </div>

    </div>
</div>