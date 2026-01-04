<div>
    <div class="px-4 py-8 mx-auto max-w-7xl">
        <div class="mb-12 d-none">
            <p class="text-sm leading-relaxed text-gray-700">
                {{
                getSetting('solutionCategory_page_description')
                }}
            </p>
        </div>
        <div class="space-y-4">
            <!-- solutionCategory Items -->
            <div class="divide-y divide-gray-100">
                @foreach ($solutionCategories as $solutionCategory)
                <div
                    class="group flex flex-col md:flex-row bg-[#F7F7F7] border border-gray-200 hover:border-gray-300 transition-colors">
                    <div class="flex items-center justify-center w-full p-4 bg-white md:w-64 shrink-0">
                        <img src="{{ asset('/storage').'/'.$solutionCategory->hero_background_image}}" alt="{{ $solutionCategory->hero_title }}"
                            class="object-cover h-auto max-w-full" />
                    </div>
                    <div class="flex flex-col flex-grow p-6 md:flex-row">
                        <a href="{{ route('solutions.show', $solutionCategory->page_slug) }}" wire:navigate
                            class="absolute inset-0 z-10">
                            <div class="flex-grow pr-4">
                                <a href="{{ route('solutions.show', $solutionCategory->page_slug) }}">
                                    <h3
                                        class="text-[#009CDE] text-[15px] font-bold mb-2 leading-snug hover:underline cursor-pointer">
                                        {{ $solutionCategory->hero_title }}
                                    </h3>
                                </a>
                                <p class="text-[13px] text-gray-700 leading-relaxed line-clamp-3">
                                    {{ $solutionCategory->hero_subtitle }}
                                </p>
                            </div>
                        </a>
                        <div
                            class="flex flex-col w-full mt-4 space-y-1 border-gray-200 md:w-48 md:mt-0 md:border-l md:pl-6 shrink-0">
                            @if ($solutionCategory->links)
                            @foreach ($solutionCategory->links as $link)
                            <a href="{{ $link['url'] }}"
                                class="text-[11px] text-[#009CDE] font-semibold hover:underline">{{ $link['label']
                                }}</a>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @if(count($solutionCategories) === 0)
                <div class="p-4 text-center text-gray-500">
                    No solution categories available at the moment.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>