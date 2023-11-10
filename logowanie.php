<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8" />
	<title>Forum o psach</title>
	<link rel="stylesheet" href="styl4.css" />
	
</head>
<body>
	<div id="baner">
		<h1>Forum wielbicieli psów</h1>
	</div>
	<div id="lewy">
		<img src="obraz.jpg" alt="foksterier" />
	</div>
	<div id="prawy1">
		<h2>Zapisz się</h2>
		<form action="logowanie.php" method="post">
			<label for="login">login:</label>
			<input type="text" id="login" name="login" required /><br/>
			<label for="haslo">hasło:</label>
			<input type="password" id="haslo" name="haslo" required /><br/>
			<label for="powhaslo">powtórz hasło:</label>
			<input type="password" id="powhaslo" name="powhaslo" required /><br/>
			<button type="submit">Zapisz</button>
		</form>
		<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$con/* zmienna */ = mysqli_connect('localhost', 'root', '', 'psy'); /* łączy z bazą psy */
			/* logowanie do php */
			$login = $_POST['login']; /* wysylanie loginu za pomocą metody post */
			$haslo = $_POST['haslo']; /* wysylanie hasła za pomocą metody post */
			$powhaslo = $_POST['powhaslo']; /* wysylanie hasła2 za pomocą metody post */

			$blad = FALSE;

			if (empty($login) || empty($haslo) || empty($powhaslo)) { /* jesli ktoras zmienna jest pusta wypisuje echo błędu */
				/* empty - Zwraca informację o tym czy podana zmienna ma wartość 'pustą'. */
				echo "<p>wypełnij wszystkie pola</p>";
				$blad = TRUE;
			}

			$kw = "SELECT login FROM uzytkownicy;"; /* wypisuje kwerende */
			$res = mysqli_query($con, $kw); /* wykonuje zapytanie SQL i zwraca uchwyt do jego wyników */
			while ($tab = mysqli_fetch_row($res)) { /* pobiera dokładnie jeden wiersz wyniku zapytania w formie tablicy */
				if ($login === $tab[0]) { /* jeśli zmienna login = zmiennej tab konto nie zostanie dodane ponieważ powtarza się
					w bazie danych */
					echo "<p>login występuje w bazie danych, konto nie zostało dodane</p>"; /* wypisuje */
					$blad = TRUE;
					break; /* przerywa wykonywania pętli */
				}
			}

			if ($haslo !== $powhaslo) { /* jesli haslo nie rowna sie powhaslo wypisuje aby wpisac takie same hasla */
				echo "<p>hasła nie są takie same, konto nie zostało dodane</p>";
				$blad = TRUE;
			}

			if ($blad === FALSE) {
				$szyfr = sha1($haslo); /* zaszyfrowanie hasla (zakropkowanie) */
				$kw = "INSERT INTO uzytkownicy VALUES (NULL, '$login', '$szyfr');"; /* wykonuje wypisana kwerendę */
				mysqli_query($con, $kw); /* wykonuje zapytanie SQL (w tym przpadku zmienną con oraz kw) i zwraca uchwyt do jego wyników */
				echo "<p>Konto zostało dodane</p>";
			}

			mysqli_close($con); /* kończy połączenie z bazą */
		}
		?>
	</div>
	<div id="prawy2">
		<h2>Zapraszamy wszystkich</h2>
		<ol>
			<li>właścicieli psów</li>
			<li>weterynarzy</li>
			<li>tych, co chcą kupić psa</li>
			<li>tych, co lubią psy</li>
		</ol>
		<a href="regulamin.html">Przeczytaj regulamin forum</a>
	</div>
	<div id="stopka">
		Stronę wykonał:
	</div>
</body>
</html>