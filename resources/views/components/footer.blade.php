<footer class="bg-slate-900 text-slate-400">
  <div class="container px-4 py-10 mx-auto lg:py-24 md:py-16">
    <!-- Footer Links Grid -->
    <div class="grid grid-cols-1 gap-8 mb-4 md:grid-cols-2 lg:grid-cols-4">
      @foreach($menus as $menu)
        <div class="space-y-4">
          <h3 class="text-lg font-bold text-white">{{ Str::of($menu->name)->after('Footer ')->title() }}</h3>
          <ul class="space-y-2">
            @foreach($menu->links as $link)
              <li><a href="{{ $link->url }}" class="hover:text-white">{{ $link->label }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>


    <!-- Footer Bottom -->
    <div class="pt-4 text-sm text-center border-t border-slate-700 lg:pt-8">
      <p>DatoHall © {{ date('Y') }}. All Rights Reserved.</p>
    </div>
  </div>
</footer>
