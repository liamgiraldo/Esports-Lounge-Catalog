CREATE TABLE games (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  checked INTEGER NOT NULL,
  source TEXT NOT NULL,
  cover_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT),
  FOREIGN KEY(cover_id) REFERENCES covers(id)
);

CREATE TABLE game_tags (
  id INTEGER NOT NULL UNIQUE,
  game_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT),
  FOREIGN KEY(game_id) REFERENCES games(id) FOREIGN KEY(tag_id) REFERENCES tags(id)
);

CREATE TABLE tags (
  id INTEGER NOT NULL UNIQUE,
  tag TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE covers (
  id INTEGER NOT NULL UNIQUE,
  cover_name TEXT NOT NULL,
  cover_ext TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO
  users(id, username, password)
VALUES
  (
    1,
    "Liam",
    "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH."
  );

CREATE TABLE groups (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

CREATE TABLE user_groups (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  group_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO
  user_groups (user_id, group_id)
VALUES
  (1, 1);

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    1,
    'Smash Ultimate',
    'All star fighter',
    0,
    'https://www.nintendolife.com/games/nintendo-switch/super_smash_bros_ultimate',
    1
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    2,
    'Mario Kart',
    'Race with nintendos all stars!',
    1,
    'https://www.amazon.com/Mario-Kart-Deluxe-17-Promotional/dp/B09R6P76JJ',
    2
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    3,
    'Minecraft',
    'The classic sandbox survival game from 2010, now on switch!',
    0,
    'https://www.gametdb.com/Switch/AEUCA',
    3
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    4,
    'FIFA 23',
    'The newest game in the FIFA soccer series',
    1,
    'https://www.eurogamer.net/heres-the-fifa-23-cover-the-last-developed-by-ea',
    4
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    5,
    'It Takes Two',
    'Co-op adventure built for two people! Game of the year.',
    0,
    'https://www.nintendolife.com/games/nintendo-switch/it_takes_two',
    5
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    6,
    'Overcooked 2',
    'Co-op cooking mayhem! Stressful hectic fun for the whole family',
    1,
    'https://en.wikipedia.org/wiki/Overcooked_2',
    6
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    7,
    'Goat Simulator 3',
    'Absolute Goat Mayhem. Be a goat with friends, and wreak havoc on society.',
    0,
    'https://www.pcgamingwiki.com/wiki/Goat_Simulator_3',
    7
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    8,
    'Dragon Ball Fighters Z',
    'Duke it out as your favorite Dragon Ball Characters. With friends or alone.',
    1,
    'https://www.amazon.com/Dragon-Ball-FIGHTERZ-Cover-Scroll/dp/B07GB85KZR',
    8
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    9,
    'Mario Party Superstars',
    'The classic Mario boardgame is back for switch! Roll the dice with up to four others. Victory awaits!',
    0,
    'https://www.amazon.com/Mario-Party-Superstars-Nintendo-Switch/dp/B097B2HQ5R?th=1',
    9
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    10,
    'Cuphead',
    'The hard as nails retro style platformer. Take on this insane challenge of a game alone or with a friend. Good luck.',
    1,
    'https://en.wikipedia.org/wiki/Cuphead',
    10
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    11,
    'Injustice 2',
    'Intense action fighting game with your favorite DC comic characters. Smash bros, but for DC. Try it out!',
    0,
    'https://www.mobygames.com/game/98017/injustice-2-ultimate-edition/cover/group-155206/cover-435903/',
    11
  );

INSERT INTO
  games (
    id,
    name,
    description,
    checked,
    source,
    cover_id
  )
VALUES
  (
    12,
    'Tetris Effect: Connected',
    'Live and breathe the tetris experience. Enjoy the surreal tetris world alone or with a friend. Relaxing fun for everyone.',
    1,
    'https://tetris.wiki/Tetris_Effect',
    12
  );

INSERT INTO
  tags (id, tag)
VALUES
  (1, 'Switch');

INSERT INTO
  tags (id, tag)
VALUES
  (2, 'Co-op');

INSERT INTO
  tags (id, tag)
VALUES
  (3, 'Playstation');

INSERT INTO
  tags (id, tag)
VALUES
  (4, '4-Player');

INSERT INTO
  tags (id, tag)
VALUES
  (5, 'Cross-Play');

INSERT INTO
  tags (id, tag)
VALUES
  (6, 'Xbox');

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (1, 1, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (2, 1, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (3, 2, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (4, 2, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (5, 3, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (6, 3, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (7, 3, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (8, 4, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (9, 4, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (10, 1, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (11, 2, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (12, 3, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (13, 5, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (14, 5, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (15, 6, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (16, 6, 5);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (17, 6, 6);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (18, 7, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (19, 7, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (20, 8, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (21, 8, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (22, 9, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (23, 9, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (24, 9, 4);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (25, 10, 1);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (26, 10, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (27, 10, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (28, 10, 5);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (29, 11, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (30, 11, 2);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (31, 12, 3);

INSERT INTO
  game_tags (id, game_id, tag_id)
VALUES
  (32, 12, 2);

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (1, 'smashultimatecover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (2, 'mariokart8deluxecover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (3, 'minecraftcover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (4, 'fifa23cover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (5, 'ittakestwocover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (6, 'overcooked2cover', 'jpg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (7, 'goatsimulator3cover', 'jpeg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (8, 'dragonballfighterszcover', 'jpeg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (9, 'mariopartysuperstarscover', 'jpeg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (10, 'cupheadcover', 'jpeg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (11, 'injustice2cover', 'jpeg');

INSERT INTO
  covers (id, cover_name, cover_ext)
VALUES
  (12, 'tetriseffectcover', 'jpeg');
