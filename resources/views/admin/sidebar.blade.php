<div class="col-md-3 sidebar-role-{{ Auth::user()->hasRole('superadmin') ? 'superadmin' : 'admin' }}">
    @foreach($laravelAdminMenus->menus as $section)
        @if($section->items)
            <div class="card sidebar-section">
                <div class="card-header">
                    {{ $section->section }}
                </div>

                <div class="card-body">
                    <ul class="nav flex-column" role="tablist">
                        @foreach($section->items as $menu)
                            <li class="nav-item menu-{!! str_replace(' ', '-', $menu->title) !!}" role="presentation">
                                <a class="nav-link" href="{{ url($menu->url) }}">
                                    {{ $menu->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br/>
        @endif
    @endforeach
</div>
