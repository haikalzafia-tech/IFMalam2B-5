<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="/home" class="logo d-flex align-items-center">
                <img src="{{ asset('template/assets/img/SIGMA.png') }}" alt="SIGMA" class="navbar-brand" height="40" />
                <span class="text-white fw-bold ms-2" style="font-size: 18px; letter-spacing: 1px;">SIGMA</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary" id="sidebarAccordion">
                @foreach ($links as $index => $link)
                    @if($link['is_dropdown'])
                        <li class="nav-item {{ $link['is_active'] ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#collapse_{{ $index }}" class="{{ $link['is_active'] ? '' : 'collapsed' }}" aria-expanded="{{ $link['is_active'] ? 'true' : 'false' }}">
                                <i class="{{ $link['icon'] }}"></i>
                                <p>{{ $link['label'] }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ $link['is_active'] ? 'show' : '' }} sidebar-submenu" id="collapse_{{ $index }}" data-bs-parent="#sidebarAccordion">
                                <ul class="nav nav-collapse">
                                    @foreach ($link['items'] as $item)
                                        <li>
                                            <a href="{{ route($item['route']) }}">
                                                <span class="sub-item">{{ $item['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item {{ $link['is_active'] ? 'active' : '' }}">
                            <a href="{{ route($link['route']) }}">
                                <i class="{{ $link['icon'] }}"></i>
                                <p>{{ $link['label'] }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Memastikan setiap klik pada menu dropdown akan menutup yang lain
    var dropdownLinks = document.querySelectorAll('#sidebarAccordion [data-bs-toggle="collapse"]');

    dropdownLinks.forEach(function(el) {
        el.addEventListener('click', function() {
            var targetId = this.getAttribute('href');
            var allCollapses = document.querySelectorAll('.sidebar-submenu');

            allCollapses.forEach(function(col) {
                if ('#' + col.id !== targetId && col.classList.contains('show')) {
                    var collapseInstance = bootstrap.Collapse.getInstance(col);
                    if (collapseInstance) {
                        collapseInstance.hide();
                    }
                }
            });
        });
    });
});
</script>
@endpush
