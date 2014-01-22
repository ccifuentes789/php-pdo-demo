<title>DVD Results</title>
<h1>DVD Results</h1>
<a href="search.php"> Back to Search Page</a>
<br />
<br />
<style>
    #movie_result{
        margin-top: 20px;
        background-color: #00FF00;
    }
</style>
<?php


$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass= 'ttrojan';

$title = $_GET['title']; // $_REQUEST['artist']

if (empty($title)){
    die('You must specify a title');
}

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$sql = "
	SELECT title, rating, genre, format
	FROM dvd_titles
	INNER JOIN formats
	ON dvd_titles.format_id = formats.id
	INNER JOIN genres
	ON dvd_titles.genre_id = genres.id
	INNER JOIN ratings
	ON dvd_titles.rating_id = ratings.id
	WHERE title LIKE ?
	ORDER BY title
";
//WHERE artist_name LIKE '%$artist%'
$statement  = $pdo->prepare($sql);
$like = '%'.$title.'%';
$statement->bindParam(1, $like);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);

//var_dump($songs);
echo "You searched for: ";
echo "<b> $title </b>";
echo "<br/> ";
?>

<?php foreach($movies as $movie) :?>
    <div id="movie_result">
        <h3>
            <?php echo $movie->title ?>


        </h3>

        <p> <b>Rating</b>: <?php echo $movie->rating ?> </p>
        <p> <b>Genre</b>: <?php echo $movie->genre?> </p>
        <p> <b>Format</b>: <?php echo $movie->format?> </p>
    </div>
<?php endforeach; ?>