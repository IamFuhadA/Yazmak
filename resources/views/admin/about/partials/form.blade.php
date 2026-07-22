<div class="soft-panel overflow-hidden p-1.5 animate-fade-in">
    <div class="rounded-lg p-6 md:p-8 space-y-6" style="background:var(--ink-950);">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Name --}}
            <div>
                <label for="name" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Name
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $about->name ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('name')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Profession --}}
            <div>
                <label for="profession" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Profession
                </label>
                <input
                    id="profession"
                    type="text"
                    name="profession"
                    value="{{ old('profession', $about->profession ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('profession')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Email Address
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $about->email ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('email')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Phone Number
                </label>
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone', $about->phone ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('phone')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div class="md:col-span-2">
                <label for="location" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Location Tagline
                </label>
                <input
                    id="location"
                    type="text"
                    name="location"
                    value="{{ old('location', $about->location ?? '') }}"
                    placeholder="e.g. New York, USA"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('location')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label for="description" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Biography / Narrative Description
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Tell your professional story..."
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >{{ old('description', $about->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Portrait Image Preview --}}
            @if(isset($about))
                <div class="md:col-span-2 rounded border p-4" style="border-color:var(--line); background:var(--ink-900);">
                    <label class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                        Current Portrait Image
                    </label>
                    @if($about->profile_image)
                        <img
                            src="{{ asset('storage/'.$about->profile_image) }}"
                            alt="Current Portrait"
                            class="w-28 h-28 object-cover rounded border"
                            style="border-color:var(--line-strong);"
                        >
                    @else
                        <p class="text-xs italic" style="color:var(--slate);">No image file uploaded.</p>
                    @endif
                </div>
            @endif

            {{-- Profile Image File Upload --}}
            <div class="md:col-span-2">
                <label for="profile_image" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Upload Portrait Image
                </label>
                <input
                    id="profile_image"
                    type="file"
                    name="profile_image"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300 file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[.68rem] file:font-mono file:uppercase file:font-semibold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--slate);"
                >
                @error('profile_image')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Resume Preview --}}
            @if(isset($about))
                <div class="md:col-span-2 rounded border p-4" style="border-color:var(--line); background:var(--ink-900);">
                    <label class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                        Current Resume Document
                    </label>
                    @if($about->resume)
                        <a
                            href="{{ asset('storage/'.$about->resume) }}"
                            target="_blank"
                            class="ink-link font-mono text-xs inline-flex items-center gap-1"
                        >
                            View Resume PDF &nearr;
                        </a>
                    @else
                        <p class="text-xs italic" style="color:var(--slate);">No resume document uploaded.</p>
                    @endif
                </div>
            @endif

            {{-- Resume Document Upload --}}
            <div class="md:col-span-2">
                <label for="resume" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Upload Resume (PDF format)
                </label>
                <input
                    id="resume"
                    type="file"
                    name="resume"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300 file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[.68rem] file:font-mono file:uppercase file:font-semibold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--slate);"
                >
                @error('resume')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="pt-4 border-t flex gap-4" style="border-color:var(--line);">
            <a href="{{ route('admin.about.index') }}" class="ghost-button rounded px-6 py-3.5 text-xs">
                Cancel
            </a>
            <button
                type="submit"
                class="gradient-button rounded px-6 py-3.5 text-xs font-semibold"
            >
                {{ isset($about) ? 'Update Biography' : 'Publish Biography' }}
            </button>
        </div>

    </div>
</div>