<ul>
@foreach($sizeSelected as $size)
<li class="choose-size {{ $rsIvt[$size] == 0 ? " out-of-stock" : "" }}" data-value="{{ $size }}" data-ivt="{{ $rsIvt[$size] }}" >{{ $sizeArr[$size]['name'] }}</li>
@endforeach
</ul>