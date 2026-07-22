<div class="soft-panel overflow-hidden p-1.5 animate-fade-in">
    <div class="rounded-lg p-6 md:p-8 space-y-6" style="background:var(--ink-950);">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Skill Name --}}
            <div>
                <label for="name" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Skill Name
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $skill->name ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('name')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Proficiency Percentage --}}
            <div>
                <label for="percentage" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Proficiency Percentage (0 - 100)
                </label>
                <input
                    id="percentage"
                    type="number"
                    name="percentage"
                    min="0"
                    max="100"
                    value="{{ old('percentage', $skill->percentage ?? '') }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('percentage')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Icon Class --}}
            <div>
                <label for="icon" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Icon Class / Tag Indicator
                </label>
                <input
                    id="icon"
                    type="text"
                    name="icon"
                    value="{{ old('icon', $skill->icon ?? '') }}"
                    placeholder="e.g. devicon-laravel-plain"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                @error('icon')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Display Order --}}
            <div>
                <label for="display_order" class="block font-mono text-[.68rem] font-semibold uppercase tracking-wider mb-2" style="color:var(--slate);">
                    Display Order Index
                </label>
                <input
                    id="display_order"
                    type="number"
                    name="display_order"
                    min="0"
                    value="{{ old('display_order', $skill->display_order ?? 0) }}"
                    class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    required
                >
                @error('display_order')
                    <p class="text-red-500 font-mono text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="pt-4 border-t flex gap-4" style="border-color:var(--line);">
            <a href="{{ route('admin.skills.index') }}" class="ghost-button rounded px-6 py-3.5 text-xs">
                Cancel
            </a>
            <button
                type="submit"
                class="gradient-button rounded px-6 py-3.5 text-xs font-semibold"
            >
                {{ isset($skill) ? 'Update Skill' : 'Publish Skill' }}
            </button>
        </div>

    </div>
</div>