<div id="{{ $id }}" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@isset($form_url)
      	<form action="{{ $form_url }}"></form>
      	@endisset
        <p>{{ $slot }} </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modal-submit-btn">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

  <div class="hidden hidden_url" data-url="{{ isset($url) ? $url : ''}}"></div>
</div>