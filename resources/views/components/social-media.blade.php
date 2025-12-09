<div class="flex space-x-4">
    @forelse($socialMediaLinks as $link)
        <a href="{{ $link['url'] }}" target="_blank" class="text-gray-400 transition-colors hover:text-white">
            @if(Str::startsWith($link['icon'], 'fab'))
                <i class="{{ $link['icon'] }} text-xl"></i>
            @else
                <span class="text-xl">{!! $link['icon'] !!}</span>

            @endif
        </a>
    @empty
        <p class="text-sm text-gray-500"></p>
    @endforelse
</div>
