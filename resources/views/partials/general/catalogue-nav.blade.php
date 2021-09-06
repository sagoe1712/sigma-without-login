@php
    function makeSubMenu($navarray){
    $list = '';
    foreach ($navarray as $navitem){

                 $list .= '<div class="col-6 col-md-3">';
                     $list .= '<h5>'.ucwords($navitem->name).'</h5>';


if(isset($navitem->category) && count($navitem->category) > 0){
    $list .= '<ul class="category-nav-listings">';
foreach ($navitem->category as $subnav){
       $list .= '<li><a href="'.url('catalogue',[str_slug($subnav->name, '-') .'-' . $subnav->id]).'">';
$list .= ucwords($subnav->name);
 $list .= "</a></li>";
 }
 $list .= '</ul>';
}
    $list .= "</div>";
    }
    return $list;
    }

    function makeMenu($navarray){
    $list = '';
    foreach ($navarray->data as $navitem){
    if(isset($navitem->child_menu) && !isset($navitem->id)){


        $list .='<div class="sigma-dropdown">';
           $list .='<button class="dropbtn">';
           $list .=ucwords($navitem->name);
          $list .=' <i class="fa fa-caret-down" aria-hidden="true"></i></button>';


    if(isset($navitem->child_menu)){

                $list .='<div class="sigma-dropdown-content">';
                 $list .='<div class="row">';
                     $list .=makeSubMenu($navitem->child_menu);
                     $list .='</div>';
                     $list .='</div>';

    }
    $list .= "</div>";
    }else{
    $list .= "<a style='color: white;'  title='".ucwords($navitem->name)."' href=".url('catalogue',[str_slug($navitem->name, '-') .'-' . $navitem->id]).">".ucwords($navitem->name)."</a>";
    }
    }
    return $list;
    }
@endphp







<div class="sigma-navbar">

    @if(isset($categories))
        @if($categories->status == 1)
            @php echo makeMenu($categories) @endphp
        @endif
    @else
        <li class="dropdown menu-item">
            <a title="" href="#">Failed to load categories</a>
        </li>
    @endif
</div>

