<?php
function slicesource($source)
{
  $pos1 = strpos($source, '.');
  if ($pos1 == false) {
    return $source;
  }
  $pos2 = strpos($source, '.', $pos1 + 1);
  if ($pos2 == false) {
    return $source;
  }
  return substr($source, $pos1 + 1, $pos2 - $pos1 - 1);
}
const checkedin = array(
  0 => 'Unavailable',
  1 => 'Available'
);
//get the current tag for this catalog entry
$id = $_GET['id'] ?? NULL;

//get all of the details of this individual game
$gresults = exec_sql_query($db, "SELECT games.name AS 'games.name', games.description AS 'games.description', games.checked AS 'games.checked', games.source AS 'games.source' FROM games WHERE games.id = $id;");

//get all of the tags for this individual game by checking the 
$tresults = exec_sql_query($db, "SELECT tags.tag AS 'tags.tag' FROM tags INNER JOIN game_tags ON (tags.id = game_tags.tag_id) WHERE (game_tags.game_id = $id);");

$grecords = $gresults->fetchAll();
$trecords = $tresults->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Details</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>
  <div class="superheader">
    <div class="esportslounge">
      <p>Cornell Esports Lounge</p>
      <p>Game Catalouge</p>
    </div>
    <div class="lag288">
      <p>&copy; lag288</p>
    </div>
  </div>
  <div class="allcontent">
    <header>
      <h1>Game Details</h1>
    </header>
    <div class="bodybox">
      <nav>
        <a href="/catalouge">Catalouge</a>
        <a href="https://centers.ggcircuit.com/CUEsportsGamingLounge">Reserve</a>
      </nav>
      <div class="gamebox">
        <a class="backbutton" href="/catalouge">← Back</a>
        <div class="gamerow">
          <div class="gameentry">
            <?php foreach ($grecords as $grecord) { ?>
              <?php $cover = exec_sql_query($db, "SELECT covers.cover_name AS 'covers.cover_name', covers.cover_ext AS 'covers.cover_ext' FROM covers WHERE covers.id = $id;");
              $coverdata = $cover->fetchAll();
              ?>
              <p class="gametitle"><?php echo htmlspecialchars($grecord['games.name']) ?></p>
              <p><?php echo htmlspecialchars(checkedin[$grecord['games.checked']]) ?></p>
              <?php foreach ($coverdata as $cdata) { ?>
                <img src="<?php echo ('/public/uploads/covers/' . $id . '.' . $cdata['covers.cover_ext']); ?>" alt="<?php echo (htmlspecialchars($cdata['covers.cover_name'])); ?>" />
              <?php } ?>
              <div class="sourcetext">
                <p>Source: <a class="sourcelink" href="<?php echo htmlspecialchars($grecord['games.source'])  ?>"><?php echo htmlspecialchars(slicesource($grecord['games.source'])) ?></a></p>
              </div>
          </div>
          <div class="contentboxsmall">
            <h2><?php echo htmlspecialchars($grecord['games.description']) ?></h2>
          <?php } ?>
          <div class="tagheader">
            <p>Tags</p>
          </div>
          <?php foreach ($trecords as $trecord) { ?>
            <div class="tag">
              <p><?php echo $trecord['tags.tag']; ?></p>
            </div>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <script src="/public/scripts/jquery-3.6.1.js"></script>
    <script src="/public/scripts/hidefilters.js"></script>
  </div>
</body>

</html>
