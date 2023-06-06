<div id="sidebar">
	<div id="logo">
		Logo
	</div>
	<ul>
		<li>
			<span> <?= $event['nume'] ?> </span>
		</li>
		<li>
			<a href=<?= "event-sumar.php?event-id=" . $event['id'] ?>>Sumar</a>
		</li>


		<li>
			<a href=<?= "event-activity.php?event-id=" . $event['id'] ?>>Activitati</a>
		</li>


		<li>
			<a href=<?= "event-budget.php?event-id=" . $event['id'] ?> >Buget</a>
		</li>

		<li>
			<a href="#">Invitati</a>
		</li>

		<li>
			<a href="#">Aranjare Mese</a>
		</li>

		

		<li>
			<a href="events.php"> <svg width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
			  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
			</svg> 		
			Evenimentele mele 
		</a>
		</li>

		<li>
			<a href="profile.php"><svg width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
</svg> Contul meu</a>
		</li>
	</ul>
</div>