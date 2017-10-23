
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>              
              <th style="text-align:left;width:150px;">Tên SP</th>
              <th style="text-align:left">Số lượng</th>                            
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                
                <td>                  
                  <a style="color:#333;font-weight:bold" href="{{ route( 'inventory.edit', [ 'id' => $item->id ]) }}">{{ $item->name }} </a>  &nbsp;
                </td>
                <td>
                  <table class="table table-bordered">
                        <tr>
                          <td></td>
                          @foreach($sizeArr as $size)                   
                          <td class="text-center">Size {{ $size['name'] }}</td>
                          @endforeach
                        </tr>                        
                        @foreach($item->colors as $color)                        
                        <tr>
                          <td style="white-space:nowrap;text-align:center;width:100px">
                          {{ $colorArr[$color->color_id]->name }}
                          </td>
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
                      </table>
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          
