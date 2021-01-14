<div class="popup hideme" onclick="closePopup()">
    <div class="backdrop_image_wrapper">
        <div class="backdrop_image"></div>
    </div>
    <form action="/undo-like" method="POST">
        @csrf
        <input id="recommendable_id" name="recommendable_id" type="number" hidden>
        <button title="Like entfernen" class="option_primary" onclick="animateOption(this)"><x-icon-heart/></button>
    </form>
</div>
