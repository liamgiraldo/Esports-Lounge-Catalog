<?php
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

  <title>Admin</title>

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
      <label for="searchbar">Search:</label>
      <input id="searchbar" class="gamesearchbar" type="text"/>
      <div class="filterbuttonbox">
        <a id="filter" class="collapsefilters"><p id="threeline" class="squished">≡</p><p id="xtext" class="hidden">&times;</p></a>
        <div id="allfilters" class="filters hidden">
          <p>Filters</p>
          <div class="filterbox">
            <label for="filteravailable">Available</label>
            <input id="filteravailable" type="checkbox">
          </div>
          <div class="filterbox">
            <label for="filterpopularity">Popularity</label>
            <input id="filterpopularity" type="checkbox">
          </div>

          <div class="filterbox">
            <label for="filterswitch">Switch</label>
            <input id="filterswitch" type="checkbox">
          </div>

          <div class="filterbox">
            <label for="filterps">Playstation</label>
            <input id="filterps" type="checkbox">
          </div>
        </div>
      </div>
      <a id="search_go" class="collapsefilters">&#128269;</a>
    </header>
    <div class="bodybox">
      <nav>
        <a href="/catalouge">Catalouge</a>
        <a href="https://centers.ggcircuit.com/CUEsportsGamingLounge">Reserve</a>
        <a href="/admin">Admin</a>
      </nav>
      <div class="gamebox">
      <form>
        
      </form>
        <?php
          $result = exec_sql_query($db, 'SELECT * FROM games');

          $gamedata = $result->fetchAll();
        ?>
        <?php foreach ($gamedata as $gdata){ ?>
          <a href="/details?<?php echo http_build_query(array(
            'id' => $gdata['id']
          ))?>">
            <div class="listentry">
              <p class="gametitle"><?php echo htmlspecialchars($gdata['name']) ?></p>
              <p><?php echo htmlspecialchars(checkedin[$gdata['checked']])?></p>
            </div>
          </a>
        <?php }?>
      </div>
    </div>
    <script src="/public/scripts/jquery-3.6.1.js"></script>
    <script src="/public/scripts/hidefilters.js"></script>
  </div>
</body>

</html>
