<div id="{{ $id }}" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @isset($form_url)
        <form action="{{ $form_url }}" method="post">
          @csrf
      @endisset
        <div class="modal-body">
            <p>{{ $slot }} </p>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" id="modal-submit-btn" value="Save changes">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      @isset($form_url)
        </form>
      @endisset
    </div>
  </div>

  <div class="hidden hidden_url" data-url="{{ isset($url) ? $url : ''}}"></div>
</div>