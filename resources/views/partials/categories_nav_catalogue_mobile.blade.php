@php
    function makeMobileSubMenu($navarray){
    $list = '';
    foreach ($navarray as $navitem){
    $list .= "<li class='nav-title'>
    ".ucwords($navitem->name);
    $list .= "</li>";
    if(isset($navitem->category) && count($navitem->category) > 0){
    foreach ($navitem->category as $subnav)
    $list .= "<li class='nav-submenu'>
    <a href=".url('catalogue',[str_slug($subnav->name, '-') .'-' . $subnav->id]).">".ucwords($subnav->name)."</a>";
    $list .= "</li>";
    }
    }
    return $list;
    }

        function makeMobileMenu($navarray){
        $list = '';
        foreach ($navarray->data as $navitem){
        $list .= "<li class='yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu'>
        <a data-toggle='dropdown' class='dropdown-toggle' aria-haspopup='true' href='#' title=".ucwords($navitem->name).">".ucwords($navitem->name)."</a>";
        if(isset($navitem->child_menu)){
        $list .="<ul role='menu' class='dropdown-menu'>";
        $list .= "<li class='menu-item menu-item-object-static_block animate-dropdown'>";
            $list .= "<div class='yamm-content'>";
            $list .= "<div class='row yamm-content-row'>";
            $list .= "<div class='col-md-6 col-sm-12'>";
                $list .= "<div class='kc-col-container'>";
                $list .= "<div class='kc_text_block'>";
                $list .= "<ul>";
                        $list .=makeMobileSubMenu($navitem->child_menu);
                $list .= "</ul>";
                $list .= "</div>";
            $list .= "</div>";
            $list .= "</div>";
            $list .= "</div>";
            $list .= "</div>";
            $list .= "</li>";
        $list .= "</ul>";
        }
        $list .= "</li>";

        }
        return $list;
        }
@endphp

<ul id="menu-departments-menu-1" class="nav">
    @if(isset($categories))
        @if($categories->status == 1)
            @php echo makeMobileMenu($categories) @endphp
        @endif
    @else
        <li class="highlight menu-item animate-dropdown">
            <a title="" href="#">Failed to load categories</a>
        </li>
    @endif
</ul>