<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">WeddingInviter</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{url('/admin')}}">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Guests
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="{{url('/admin/guests/attending')}}">Attending</a>
          <a class="dropdown-item" href="#">Not Attending</a>
          <a class="dropdown-item" href="#">Awaiting Reply</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Reports</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Emails</a>
      </li>
    </ul>
  </div>
</nav>