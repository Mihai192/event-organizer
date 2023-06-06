<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

	session_start();

	if (!checkLogin())
		_redirect('login.php');


	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$conn = connectToDatabase($servername, $username, $password, $database);

	$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$result = $conn->query($sql);

	$result = $result->fetch_assoc();
	$nume   = $result['nume'];
	$prenume = $result['prenume'];
	$email  = $result['email'];
	$user_id = $result['id'];



	$event = "";
	$event_id = "";
	if (isset($_GET['event-id']))
	{
		$event_id = $_GET['event-id']; // sanitizare
		
		$sql = "SELECT * FROM event WHERE id = {$event_id} LIMIT 1";

		$event = $conn -> query($sql) -> fetch_assoc();


		
		
		
	}
	else
	{
		header("Location: " . dirname($_SERVER['PHP_SELF']) . "/events.php");
		die();
	}
	
	
	// gets all ids for budget lists
	function getAllBudgetLists() {
		$sql = "SELECT * FROM budgetlist";

		global $conn;
		$list = [];

		$result = $conn->query($sql);

		while ($row = $result -> fetch_assoc()) {
			$list[] = $row;
		}

		return $list;
	}

	function getAllItemsForBudgetList($listId, $eventId) {
		$sql = "SELECT * FROM budgetlistitem WHERE budget_list_id = {$listId} AND event_id = {$eventId}";

		global $conn;
		$list = [];
		$result = $conn->query($sql);

		while ($row = $result -> fetch_assoc()) {
			$list[] = $row;
		}
		return $list;
	}


	
?>


<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title>Event organizer - Eveniment activitati</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<link rel="stylesheet" type="text/css" href="styles/events.css">
	<link rel="stylesheet" type="text/css" href="styles/sidebar-animation.css">
	<style>
		i {
			width: 10px;
			height: 10px;
			color: green;
			display: inline-block;
		}

		table a {
			margin: 0 1.5rem;
			display: inline-block;
		}
		

		.fa-check {
			color: green;
		}

		.fa-xmark {
			color: red;
		}

		.fa-trash {
			color: black;
		}

		.fa-pen-to-square {
			color: #b5b517;
		}
	</style>
</head>
<body>
	<?php require "templates/sidebar-event.php" ?>

	<main id="main" style="margin-bottom:10rem">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		<h1> Liste bugete </h1>

		<!-- <h2>Add Event Activity</h2>
		<form action="event-activity.php" method="POST">
			<div class="form-group">
				<label for="">Titlu</label>
				<input type="text" class="form-control" placeholder="Titlue" name="titlu" style="max-width: 400px;" required>
			</div>

			<div class="form-group">
				<label for="">Data</label>
				<input type="date" class="form-control" placeholder="Data" name="data" required style="max-width: 400px;" required>
			</div>
			
			<input type="text" name="event-id" value=<?= $event_id ?> hidden>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	 -->
    
    <!-- <h2>Modify Event Activity</h2>
    <form action="modify_event_activity.php" method="POST">
        <label for="activity_id">Activity ID:</label>
        <input type="text" id="activity_id" name="activity_id" required><br><br>
        
        <label for="titlu">Title:</label>
        <input type="text" id="titlu" name="titlu" required><br><br>
        
        <label for="detalii">Details:</label>
        <input type="text" id="detalii" name="detalii"><br><br>
        
        <label for="deadline">Deadline:</label>
        <input type="text" id="deadline" name="deadline" required><br><br>
        
        <label for="event_id">Event ID:</label>
        <input type="text" id="event_id" name="event_id" required><br><br>
        
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required><br><br>
        
        <input type="submit" value="Modify Event Activity">
    </form> -->

		
		<?php

			$lists = getAllBudgetLists();

			if (count($lists) > 0) {
				
				
				for ($i = 0; $i < count($lists); $i ++)
				{
					echo "<h3>" . $lists[$i]['nume'] . "</h3>";

					$items = getAllItemsForBudgetList($lists[$i]['id'], $event['id']);

					
						echo "<table class='table table-striped' id = {$lists[$i]['id']} >";
						echo "
						<thead>
							<tr>
								<th scope='col'>id</th>
								<th scope='col'>nume</th>
								<th scope='col'>Nr unitati</th>
								<th scope='col'>Pret/unitate</th>
								<th scope='col'>Avans</th>
								<th scope='col'>Rest de plata</th>
								<th scope='col'>Actions</th>
							</tr>
						</thead>";
					
					// Output data of each row
					foreach ($items as $row) {
						echo "<tr scope='row'>";
						echo "<td class='id'>" . $row['id'] . "</td>";
						echo "<td class='nume'>" . $row['nume'] . "</td>";
						echo "<td class='nr_unitati'>" . isset($row['nr_unitati']) . "</td>";
						echo "<td class='avans'>" . $row['avans'] . "</td>";
						echo "<td class='rest_de_plata'>" . $row['rest_de_plata'] . "</td>"; 
						echo "<td>" . 
							"<a href='#'> <i class='fa-solid fa-check'></i> </a>" .
							"<a href='#'> <i class='fa-solid fa-xmark'></i></a>" .
							"<a href='#'> <i class='fa-solid fa-pen-to-square'></i> </a>" . 
							"<a href='#'> <i class='fa-solid fa-trash'></i> </a>" . "</td>";
						echo "</tr>";
					}
					
					echo "</table>";
					
					
					echo "<form id = {$lists[$i]['id']} > 
								<input type='text' placeholder='Cost nou'>
								<input type='submit' name='submit'>
						  </form>";
				}
				
			
			
			} else {
				echo "Nu ai nicio o lista de bugete.";
			}
		?>


		
	</main> 

	<?php require "templates/footer-user.php" ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>


	<script>

		const table = document.querySelector('table');
		const tableRows = Array.from(table.rows);
		
		function checkMark(row, button) {
			

			const statusCell = row.querySelector('.status');

			
			statusCell.textContent = 'Terminata';

			updateEventActivityStatus(parseInt(row.querySelector('.id').textContent), 1);

		}



		function crossMark(row, button) {
			console.log(row, button);

			const statusCell = row.querySelector('.status');

			
			statusCell.textContent = 'Neterminata';

			updateEventActivityStatus(parseInt(row.querySelector('.id').textContent), 0);
		}


		function garbageMark(row, button) {
			
			let id = parseInt(row.querySelector('.id').textContent);
			
			deleteEventActivity(id, row);
		}

		function deleteRow(row) {
			row.remove();
		}

		function deleteEventActivity(id, row) {
			const data = {
				eventActivityId: id,
			};

			
			// Make the HTTP request to the PHP file using fetch
			fetch('delete-activity.php', {
				method: 'POST',
				headers: {
				'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(data => {
				// Handle the response from the PHP file
				deleteRow(row);
			})
			.catch(error => {
				// Handle any errors that occur during the request
				console.error('Error:', error);
			});
		}


		function updateEventActivityStatus(eventActivityId, newStatus) {
			// Prepare the data to be sent in the request body
			const data = {
				eventActivityId: eventActivityId,
				newStatus: newStatus
			};

			console.log(data);
			// Make the HTTP request to the PHP file using fetch
			fetch('update-status.php', {
				method: 'POST',
				headers: {
				'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(data => {
				// Handle the response from the PHP file
				console.log(data);
			})
			.catch(error => {
				// Handle any errors that occur during the request
				console.error('Error:', error);
			});
		}

		
		tableRows.forEach((row) => {
			row.addEventListener('click', (e) => {
				e.preventDefault();
				if (e.target.tagName === 'I') {
					if (e.target.classList.contains('fa-check')) {
						checkMark(e.target.parentElement.parentElement.parentElement, e.target);
					}
					else if (e.target.classList.contains('fa-pen-to-square')) {

					}
					else if (e.target.classList.contains('fa-xmark')) {
						crossMark(e.target.parentElement.parentElement.parentElement, e.target);
					}
					else {
						garbageMark(e.target.parentElement.parentElement.parentElement, e.target);
					}
				}
			});
		});



		const forms = document.querySelectorAll('form');

		forms.forEach((form) => {
			form.addEventListener('click', (e) => {
				e.preventDefault();
				console.log(e.target.parentElement);
				//createItemWithName()
			})
		});

	</script>
</body>
</html>
