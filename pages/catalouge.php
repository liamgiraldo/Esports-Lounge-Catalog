<?php
define("MAX_FILE_SIZE", 1000000);

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


$coveruploadfb = array(
  'other_error' => False,
  'large_error' => False
);

$coverupload_name = NULL;
$coverupload_ext = NULL;
if (is_user_logged_in() && $is_admin) {
  if (isset($_POST["addresults"])) {
    $gamename = trim($_POST['gamename']);
    $gamedesc = trim($_POST['gamedesc']);
    $gamesource = trim($_POST['gamesource']);
    $tagstoadd = array();
    $tresult = exec_sql_query($db, 'SELECT * FROM tags');
    $tagdata = $tresult->fetchAll();
    foreach ($tagdata as $tdata) {
      if (isset($_POST['add' . $tdata['tag']])) {
        array_push($tagstoadd, trim($_POST['add' . $tdata['tag']]));
      }
    }

    $coverupload = $_FILES['jpeg-file'];

    $formvalid = True;

    if ($coverupload['error'] == UPLOAD_ERR_OK) {
      $coverupload_name = basename($coverupload['name']);

      $coverupload_ext = strtolower(pathinfo($coverupload_name, PATHINFO_EXTENSION));

      if (!in_array($coverupload_ext, array('jpeg'))) {
        $formvalid = False;
        $coveruploadfb['other_error'] = True;
      }
    } else if ($coverupload['error'] == UPLOAD_ERR_INI_SIZE || $coverupload['error'] == UPLOAD_ERR_FORM_SIZE) {
      $formvalid = False;
      $coveruploadfb['large_error'] = True;
    } else {
      $formvalid = False;
      $coveruploadfb['other_error'] = True;
    }
    if ($formvalid) {
      $cresult = exec_sql_query(
        $db,
        "INSERT INTO covers (cover_name, cover_ext) VALUES (:cover_name, :cover_ext)",
        array(
          ':cover_name' => $coverupload_name,
          ':cover_ext' => $coverupload_ext
        )
      );

      if ($cresult) {
        $cover_id = $db->lastInsertId('id');
        $coverpath = 'public/uploads/covers/' . $cover_id . '.' . $coverupload_ext;
      }
      if (move_uploaded_file($coverupload['tmp_name'], $coverpath) == False) {
        error_log("Failed to store upload. Check that your path exists.");
      }
      exec_sql_query(
        $db,
        "INSERT INTO games (name, description, source, checked, cover_id) VALUES (:name, :description, :source, :checked, :cover_id)",
        array(
          ':name' => $gamename,
          ':description' => $gamedesc,
          ':source' => $gamesource,
          ':checked' => 0,
          ':cover_id' => $cover_id
        )
      );
      foreach ($tagstoadd as $indtag) {
        $tag_id = exec_sql_query(
          $db,
          "SELECT id FROM tags WHERE tag = :tag",
          array(
            ':tag' => $indtag
          )
        )->fetchAll()[0]['id'];

        exec_sql_query(
          $db,
          "INSERT INTO game_tags (game_id, tag_id) VALUES (:game_id, :tag_id)",
          array(
            ':game_id' => $cover_id,
            ':tag_id' => $tag_id
          )
        );
      }
    }
  }
}
$selectquery = 'SELECT * FROM games';
if (isset($_GET['submitfilters'])) {
  $selectstring = array();
  $tresult = exec_sql_query($db, 'SELECT * FROM tags');
  $tagdata = $tresult->fetchAll();
  foreach ($tagdata as $tdata) {
    if (isset($_GET['filter' . $tdata['tag']])) {
      array_push($selectstring, '"' . $_GET['filter' . $tdata['tag']] . '"');
    }
  }
  $selectstring = implode(", ", $selectstring);
  $selectquery = "SELECT DISTINCT games.id, name, source, cover_id, checked FROM games
  INNER JOIN game_tags ON games.id = game_tags.game_id
  INNER JOIN tags ON game_tags.tag_id = tags.id
  WHERE tags.tag IN ({$selectstring})";
  if (isset($_GET['filterNone'])) {
    $selectquery = 'SELECT * FROM games';
  }
}
const checkedin = array(
  0 => 'Unavailable',
  1 => 'Available'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo&family=Manrope:wght@300&display=swap" rel="stylesheet">
  <title>Catalouge</title>

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
      <p>Search by filter:</p>
      <div class="filterbuttonbox">
        <a id="filter" class="collapsefilters">
          <p id="threeline" class="squished">Select Filters</p>
        </a>
        <div id="allfilters" class="filters hidden">
          <p>Filters</p>
          <?php
          $tresult = exec_sql_query($db, 'SELECT * FROM tags');
          $tagdata = $tresult->fetchAll();
          ?>
          <form method="GET" action="/catalouge">
            <div class="filterbox">
              <label for="filterNone">No Filters</label>
              <input id="filterNone" type="checkbox" name="filterNone" value="None">
            </div>
            <?php foreach ($tagdata as $tdata) { ?>
              <div class="filterbox">
                <label for="filter<?php echo $tdata['tag'] ?>"><?php echo $tdata['tag'] ?></label>
                <input id="filter<?php echo $tdata['tag'] ?>" type="checkbox" name="filter<?php echo $tdata['tag'] ?>" value="<?php echo $tdata['tag'] ?>">
              </div>
            <?php } ?>
            <input class="submitfilters" id="submitfilters" type="submit" value="Search" name="submitfilters">
            </label>
          </form>
        </div>
      </div>
      <?php if (is_user_logged_in()) { ?>
        <a class="loginbutton" href="<?php echo logout_url(); ?>">Log Out</a>
      <?php } else { ?>
        <a id="hideloginbutton" class="loginbutton">Admin Login</a>
        <div id="hiddenlogin" class="loginbox hidden">
          <p>Login</p>
          <?php echo login_form('/catalouge', $session_messages); ?>
        </div>
      <?php } ?>
    </header>
    <div class="bodybox">
      <nav>
        <a href="/catalouge">Catalouge</a>
        <a href="https://centers.ggcircuit.com/CUEsportsGamingLounge">Reserve</a>
      </nav>
      <div class="gamebox">
        <?php if (is_user_logged_in()) { ?>
          <form class="insertform" method="post" action="/catalouge" enctype="multipart/form-data">
            <p class="headerwithline">Admin Panel - Insert Game</p>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
            <div class="insertbox">
              <label for="gamename_field">Insert Name:</label>
              <input id="gamename_field" type="text" name="gamename" />
            </div>
            <div class="insertbox">
              <label for="gamedesc_field">Insert Description:</label>
              <input id="gamedesc_field" type="text" name="gamedesc" />
            </div>
            <div class="insertbox">
              <label for="upload_cover">Upload Cover (.jpeg only, < 1MB): </label>
              <input id="upload_cover" type="file" name="jpeg-file" accept="image/*">
            </div>
            <div class="insertbox">
              <label for="gamesource_field">Game source (links supported): </label>
              <input id="gamesource_field" type="text" name="gamesource" />
            </div>
            <p class="headerwithline">Add tags</p>
            <?php foreach ($tagdata as $tdata) { ?>
              <div class="filterbox lightbg">
                <label for="add<?php echo $tdata['tag'] ?>"><?php echo $tdata['tag'] ?></label>
                <input id="add<?php echo $tdata['tag'] ?>" type="checkbox" name="add<?php echo $tdata['tag'] ?>" value="<?php echo $tdata['tag'] ?>">
              </div>
            <?php } ?>
            <div class="submitright">
              <input class="sitebutton" type="submit" value="Add Results" name="addresults" />
            </div>
          </form>
        <?php } ?>
        <?php
        $result = exec_sql_query($db, $selectquery);


        $gamedata = $result->fetchAll();
        ?>
        <?php $count = 1;
        foreach ($gamedata as $gdata) { ?>
          <?php $gdataid = $gdata['cover_id']; ?>
          <?php $cover = exec_sql_query($db, "SELECT covers.cover_name AS 'covers.cover_name', covers.cover_ext AS 'covers.cover_ext' FROM covers WHERE covers.id = $gdataid;");
          $coverdata = $cover->fetchAll();
          ?>
          <?php if ($count % 3 == 1) { ?>
            <div class="gamerow">
            <?php } ?>
            <a href="/details?<?php echo http_build_query(array(
                                'id' => $gdata['cover_id']
                              )) ?>" aria-label="Link to game details">
              <div class="gameentry">
                <p class="gametitle"><?php echo htmlspecialchars($gdata['name']) ?></p>
                <p><?php echo htmlspecialchars(checkedin[$gdata['checked']]) ?></p>
                <?php foreach ($coverdata as $cdata) { ?>
                  <img src="<?php echo ('/public/uploads/covers/' . $gdataid . '.' . $cdata['covers.cover_ext']); ?>" alt="<?php echo (htmlspecialchars($cdata['covers.cover_name'])); ?>" />
                <?php } ?>
                <div class="sourcetext">
                  <p class="st">Source:
                    <a class="sourcelink" href="<?php echo htmlspecialchars($gdata['source']) ?>"><?php echo htmlspecialchars(slicesource($gdata['source'])) ?></a>
                  </p>
                </div>
              </div>
            </a>
            <?php if ($count % 3 == 0) { ?>
            </div>
          <?php } ?>
          <?php $count++; ?>
        <?php } ?>
      </div>
    </div>
    <script src="/public/scripts/jquery-3.6.1.js"></script>
    <script src="/public/scripts/hidefilters.js"></script>
  </div>
</body>

</html>
