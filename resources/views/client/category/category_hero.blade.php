
    {{-- <li><a href="#">Fresh Meat</a></li>
    <li><a href="#">Vegetables</a></li>
    <li><a href="#">Fruit & Nut Gifts</a></li>
    <li><a href="#">Fresh Berries</a></li>
    <li><a href="#">Ocean Foods</a></li>
    <li><a href="#">Butter & Eggs</a></li>
    <li><a href="#">Fastfood</a></li>
    <li><a href="#">Fresh Onion</a></li>
    <li><a href="#">Papayaya & Crisps</a></li>
    <li><a href="#">Oatmeal</a></li>
    <li><a href="#">Fresh Bananas</a></li> --}}
    @foreach($categories as $category)
    <li><a href="{{ route('getbycategory',['id'=>$category->id]) }}">{{ $category->name }}</a></li>
    @endforeach
