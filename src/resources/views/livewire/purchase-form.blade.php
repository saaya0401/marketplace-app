<form class="purchase-form" method="post" action="{{url('/purchase/' . $item['id'] . '/stripe')}}">
    @csrf
    <div class="purchase-content">
    <div class="purchase-info">
        <div class="purchase-info__item">
            <div class="purchase-item__image">
                <img src="{{Storage::url($item['image'])}}" alt="商品画像" class="purchase-item__img">
            </div>
            <div class="purchase-item__header">
                <h2 class="purchase-item__title">{{$item->title}}</h2>
                <div class="purchase-item__price"><span class="purchase-item__price-yen">&yen;</span>{{$item->formatted_price}}</div>
            </div>
        </div>
        <div class="purchase-info__method">
            <h3 class="purchase-method__title">支払い方法</h3>
            <div class="purchase-method__select-area">
                <select wire:model.live="paymentMethod" name="payment_method" class="purchase-method__select">
                    <option value="" selected disabled>選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード払い">カード払い</option>
                </select>
                <div class="purchase-form__error">
                    @error('payment_method')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="purchase-info__address">
            <div class="purchase-info__address--header">
                <h3 class="purchase-address__title">配送先</h3>
                <a href="{{url('/purchase/address/' . $item['id'])}}" class="purchase-address__edit">変更する</a>
            </div>
            <div class="purchase-address">
                <div class="purchase-address__postal_code">
                    〒 {{$profile->postal_code}}
                </div>
                <div class="purchase-address__address-building">
                    {{$profile->address}} {{$profile->building}}
                </div>
            </div>
        </div>
    </div>
    <div class="purchase-confirm">
        <table class="purchase-confirm__table">
            <tr class="purchase-confirm__table-row">
                <th class="purchase-confirm__table-header">商品代金</th>
                <td class="purchase-confirm__table-price"><span class="purchase-confirm__table-price--yen">&yen;</span>{{$item->formatted_price}}</td>
            </tr>
            <tr class="purchase-confirm__table-row">
                <th class="purchase-confirm__table-header">支払い方法</th>
                <td class="purchase-confirm__table-description">
                    {{ $paymentMethod ?: '' }}
                </td>
            </tr>
        </table>
        <input type="hidden" name="profile_id" value="{{Auth::user()->profile->id}}">
        <div class="purchase-confirm__button">
            <button type="submit" class="purchase-confirm__button-submit">購入する</button>
        </div>
    </div>
</div>

</form>