 {{-- 產生控件 --}}
 <li class="inventory sortStatusSet">
     <div class="title">
         <p class="subtitle">{{ $title }}</p>
     </div>

     <div class="inner">
         {{-- 要打開就在ios_switch 後面再加個on --}}
         <div
             class="ios_switch {{ $value == 0 ? '' : 'on ' }} {{ $set['can_review'] == '1' ? 'radio_btn_switch' : '' }}">

             <input name="{{ $name }}" type="text" value="{{ $value }}">
             <div class="box">
                 <span class="ball"></span>
             </div>
         </div>

         {{-- 提示窗 --}}
         @if (!empty($tip))
             <div class="tips">
                 <span class="title">TIPS</span>
                 <p>{!! $tip !!}</p>
             </div>
         @endif
     </div>
 </li>
