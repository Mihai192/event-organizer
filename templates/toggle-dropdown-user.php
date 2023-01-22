<button id="toggle">
	<svg width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
	  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
	</svg>
</button>

		

<div class="dropdown">
  <button class="profile-icon btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <?= strtoupper($nume[0] . $prenume[0]) ?> 
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="events.php">Acasa</a></li>
    <li><a class="dropdown-item" href="profile.php">Contul meu</a></li>
    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
  </ul>
</div>