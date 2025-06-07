<div>
    @if(Auth::id() !== $item->user_id)
        <div class="complete-button">
            <button wire:click="openModal()" type="button" class="complete-form__button">取引を完了する</button>
        </div>
    @endif

    @if($showModal)
        <div class="modal">
            <div class="modal-content">
                <p class="modal-text">
                    <span class="text-content">取引が完了しました</span>
                    <span class="text-circle">。</span>
                </p>
                <div class="rating-area">
                    <h6 class="rating-text">今回の取引相手はどうでしたか？</h6>
                    <div class="rating-counts">
                        @for($i=1; $i<=5; $i++)
                            <button type="button" wire:click="setRating({{ $i }})" class="rating-button">
                                @if($i <= $rating)
                                    <img src="{{ asset('icon/rating-star-yellow.png') }}" alt="星" class="mypage-user__rating-star">
                                @else
                                    <img src="{{ asset('icon/rating-star.png') }}" alt="星" class="mypage-user__rating-star">
                                @endif
                            </button>
                        @endfor
                    </div>
                </div>
                <form wire:submit.prevent="submitRating" class="modal-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button class="modal-form__submit" type="submit">送信する</button>
                </form>
            </div>
        </div>
    @endif
</div>
