@php
    function makeBodySubMenu($navarray){
    $list = '';
    foreach ($navarray as $navitem){
    $list .= "<li class='nav-title'>
    ".ucwords($navitem->name);
    $list .= "</li>";
    if(isset($navitem->category) && count($navitem->category) > 0){
    foreach ($navitem->category as $subnav)
    $list .= "<li class='cat-item'>
    <a href=".url('catalogue',[str_slug($subnav->name, '-') .'-' . $subnav->id]).">".ucwords($subnav->name)."</a>";
    $list .= "</li>";
    }
    }
    return $list;
    }

        function makeBodyMenu($navarray){
        $list = '';
        foreach ($navarray->data as $navitem){
        $list .= " <li class='product_cat'>
        <span class='show-all-cat-dropdown' title=".ucwords($navitem->name).">".ucwords($navitem->name)."<span class='child-indicator'></span></span>";
        if(isset($navitem->child_menu)){
                $list .= "<ul style='display: none'>";
                        $list .=makeBodySubMenu($navitem->child_menu);
                $list .= "</ul>";
        }
        $list .= "</li>";

        }
        return $list;
        }
@endphp


<ul class="show-all-cat">
    @if(isset($categories))
        @if($categories->status == 1)
            @php echo makeBodyMenu($categories) @endphp
        @endif
    @else
        <li class="product_cat">
            <a title="" href="#">Failed to load categories</a>
        </li>
    @endif
</ul>