<table class="table table-bordered" id="table-list-data">
  <tr>
    <th>#</th>              
    <th style="text-align:left">Tên SP</th>
    <th style="text-align:right">Giá</th>
    <th style="text-align:left">Màu</th>
    @foreach($sizeArr as $size)                   
    <th style="text-align:right">{{ $size['name'] }}</th>
    @endforeach                           
  </tr>
  <tbody>
  @if( $items->count() > 0 )
    <?php $i = 0; ?>
    @foreach( $items as $item )
      <?php $i ++; 

      ?>
     <?php $k = 0; ?>
      @foreach($item->colors as $color) 
      <?php $k++; ?>
    <tr id="row-{{ $item->id }}">
      @if($k == 1)
      <td ><span class="order">{{ $i }}</span></td>                
      <td >                  
        {{ $item->name }}
      </td>
      <td style="text-align:right">{{ number_format($item->price_sell) }}</td>
      @else
      <td></td>              
      <td></td>
      <td></td>
      @endif
      <td> {{ $colorArr[$color->color_id]->name }}</td>
      @foreach($sizeArr as $size)                               
        <?php 
        $arrInv = [];
        $rsInv = DB::table('product_inventory')->where('product_id', $item->id)->orderBy('color_id')->orderBy('size_id')->get();
        foreach($rsInv as $inv){
            $arrInv[$inv->color_id][$inv->size_id] = $inv->amount;
        }  
        $valueAmount = !empty($arrInv) && isset($arrInv[$color->color_id][$size->id]) ? $arrInv[$color->color_id][$size->id] : "";
        ?>               
        <td style="text-align:right">
          <strong>{{ $valueAmount ? number_format($valueAmount) : '' }}</strong>
        </td>
        @endforeach
      
    </tr> 
    @endforeach
    @endforeach            
  @endif

</tbody>
</table>