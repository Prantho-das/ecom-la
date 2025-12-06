<footer class="bg-slate-900 text-slate-400">
  <div class="container mx-auto px-4 lg:py-24 md:py-16 py-10">
    <!-- Footer Links Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-4">
      @foreach($menus as $menu)
        <div class="space-y-4">
          <h3 class="font-bold text-white text-lg">{{ Str::of($menu->name)->after('Footer ')->title() }}</h3>
          <ul class="space-y-2">
            @foreach($menu->links as $link)
              <li><a href="{{ $link->custom_url }}" class="hover:text-white">{{ $link->label }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>

    <x-social-media />

    <!-- Footer Bottom -->
    <div class="border-t border-slate-700 lg:pt-8 pt-4 text-center text-sm">
      <p>DatoHall © {{ date('Y') }}. All Rights Reserved.</p>
    </div>
  </div>
</footer>
