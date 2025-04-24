<div class="p-4 bg-white shadow rounded w-full max-w-xl mx-auto">
    <form wire:submit.prevent="crawl">
        <label for="url" class="block font-semibold mb-2">Input URL to crawl post:</label>
        <input type="text" wire:model="url" id="url"
               class="w-full p-2 border rounded @error('url') border-red-500 @enderror"
               placeholder="https://example.com/blog" />

               
               @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
               
        <button type="submit"
            class="px-4 py-2 btn btn-primary text-white rounded"
            wire:click="crawl">
            Crawl
        </button>
        <div wire:loading wire:target="crawl" class="mt-2 text-info">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Crawling...
        </div>
    </form>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif
</div>
