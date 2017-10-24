<table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>              
              <th style="text-align:left;width:150px;">Tên SP</th>
              <th style="text-align:right;width:150px;">Giá</th>
              <th style="text-align:left;width:150px;">Màu</th>
              @foreach($sizeArr as $size)                   
              <th class="text-right">{{ $size['name'] }}</th>
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
                <td rowspan="{{ $item->colors->count() }}"><span class="order">{{ $i }}</span></td>                
                <td rowspan="{{ $item->colors->count() }}">                  
                  <a style="color:#333;font-weight:bold" href="{{ route( 'inventory.edit', [ 'id' => $item->id ]) }}">{{ $item->name }} </a>
                </td>
                <td class="text-right" rowspan="{{ $item->colors->count() }}">{{ number_format($item->price_sell) }}</td>
                @endif
                <td> {{ $colorArr[$color->color_id]->name }}</td>
                @foreach($sizeArr as $size)                               
                  <?php 
                  $arrInv = [];
                  //get inventory
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