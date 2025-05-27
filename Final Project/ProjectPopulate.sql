--  Roles
INSERT INTO Roles (Role_ID, Role_Name, Role_Description) VALUES
--  Vanguard
(1, 'Vanguard - Dive', 'Frontline tanks that initiate quickly and aggressively.'),
(2, 'Vanguard - Peel', 'Frontline tanks protecting allies by disrupting threats.'),
(3, 'Vanguard - Shield', 'Frontline tanks specializing in shields and barriers.'),
(4, 'Vanguard - Control', 'Frontline tanks controlling space and crowd movements.'),
(5, 'Vanguard - Pressure', 'Frontline tanks constantly threatening enemy positions.'),

--  Duelist
(6, 'Duelist - Dive', 'Mobile duelists that engage aggressively into enemy lines.'),
(7, 'Duelist - Poke', 'Duelists specializing in long-range harassment and chip damage.'),
(8, 'Duelist - Control', 'Duelists locking down areas and objectives.'),
(9, 'Duelist - Pressure', 'Duelists maintaining continuous threat across the map.'),
(10, 'Duelist - Buff', 'Duelists who enhance themselves or allies with temporary advantages.'),
(11, 'Duelist - Peel', 'Duelists protecting allies by disrupting enemy movement.'),

--  Strategist
(12, 'Strategist - Poke', 'Strategists supporting from range and harassing enemies.'),
(13, 'Strategist - Pressure', 'Strategists creating ongoing strategic pressure across the field.'),
(14, 'Strategist - Shield', 'Strategists providing shields and defensive tools.'),
(15, 'Strategist - Control', 'Strategists manipulating zones and battlefield control.'),
(16, 'Strategist - Buff', 'Strategists boosting teammates through enhancements and buffs.'),
(17, 'Strategist - Peel', 'Strategists protecting allies by disrupting enemy threats.'),
(18, 'Strategist - Dive', 'Strategists assisting in aggressive engagements and dives.');

--  Attack Type
INSERT INTO Attack_Type (Attack_ID, Attack_Name) VALUES
(1, 'Melee'),
(2, 'Projectile'),
(3, 'Hitscan');

--  Characters
INSERT INTO Characters (Char_ID, Char_Name, Role_ID, Attack_ID, Health, Move_Speed, Win_Rate, Pick_Rate, Difficulty, Char_Release) VALUES
--  Vanguard
(1, 'Captain America', 1, 1, 675, 6.0, 52.67, 5.02, 2, "2024-12-6"),
(2, 'Doctor Strange', 3, 2, 600, 6.0, 49.36, 19.21, 2, "2024-12-6"),
(3, 'Groot', 3, 1, 700, 6.0, 50.46, 12.11, 3, "2024-12-6"),
(4, 'Hulk', 5, 1, 800, 6.0, 50.31, 3.9, 2, "2024-12-6"),
(5, 'Magneto', 3, 2, 650, 6.0, 49.36, 17.57, 3, "2024-12-6"),
(6, 'Peni Parker', 4, 2, 625, 6.0, 50.97, 8.91, 3, "2024-12-6"),
(7, 'The Thing', 5, 1, 750, 6.0, 50.08, 13.68, 2, "2025-02-21"),
(8, 'Thor', 5, 1, 700, 6.0, 53.13, 10.53, 2, "2024-12-6"),
(9, 'Venom', 1, 1, 725, 6.0, 50.1, 9.06, 3, "2024-12-6"),
-- Duelist
(10, 'Black Panther', 6, 1, 650, 7.0, 54.24, 3.05, 3, "2024-12-6"),
(11, 'Black Widow', 7, 3, 600, 6.0, 44.1, 1.14, 2, "2024-12-6"),
(12, 'Hawkeye', 7, 2, 600, 6.0, 48.14, 2.48, 2, "2024-12-6"),
(13, 'Hela', 7, 3, 625, 6.0, 51.32, 6.96, 3, "2024-12-6"),
(14, 'Human Torch', 8, 2, 600, 6.0, 47.18, 3.07, 3, "2025-02-21"),
(15, 'Iron Fist', 6, 1, 650, 6.0, 51.05, 2.09, 3, "2024-12-6"),
(16, 'Iron Man', 8, 2, 600, 6.0, 49.5, 3.24, 2, "2024-12-6"),
(17, 'Magik', 9, 1, 625, 6.0, 54.97, 4.67, 3, "2024-12-6"),
(18, 'Mister Fantastic', 11, 1, 650, 6.0, 51.18, 1.69, 3, "2025-01-10"),
(19, 'Moon Knight', 8, 2, 625, 6.0, 45.58, 8.2, 3, "2024-12-6"),
(20, 'Namor', 8, 2, 650, 6.0, 47.26, 8.14, 3, "2024-12-6"),
(21, 'Psylocke', 6, 3, 600, 6.0, 50.94, 5.69, 3, "2024-12-6"),
(22, 'Scarlet Witch', 9, 2, 600, 6.0, 48.29, 5.72, 3, "2024-12-6"),
(23, 'Spider-Man', 6, 1, 600, 6.0, 53.56, 6.22, 2, "2024-12-6"),
(24, 'Squirrel Girl', 9, 2, 600, 6.0, 45.53, 6.19, 3, "2024-12-6"),
(25, 'Star-Lord', 9, 2, 600, 6.0, 50.71, 6.2, 2, "2024-12-6"),
(26, 'Storm', 10, 2, 600, 6.0, 54.51, 2.74, 3, "2024-12-6"),
(27, 'The Punisher', 8, 3, 625, 6.0, 48.68, 8.96, 3, "2024-12-6"),
(28, 'Winter Soldier', 9, 2, 650, 6.0, 51.7, 11.2, 3, "2024-12-6"),
(29, 'Wolverine', 9, 1, 700, 7.0, 49.63, 2.35, 3, "2024-12-6"),
-- Strategist
(30, 'Adam Warlock', 12, 2, 600, 6.0, 53.38, 4.65, 3, "2024-12-6"),
(31, 'Cloak & Dagger', 13, 2, 600, 6.0, 47.8, 26.55, 3, "2024-12-6"),
(32, 'Invisible Woman', 14, 2, 600, 6.0, 48.71, 20.22, 3, "2025-1-10"),
(33, 'Jeff The Land Shark', 18, 2, 625, 6.0, 45.13, 5.38, 3, "2024-12-6"),
(34, 'Loki', 15, 2, 600, 6.0, 52.55, 7.4, 3, "2024-12-6"),
(35, 'Luna Snow', 12, 2, 600, 6.0, 48.04, 15.3, 3, "2024-12-6"),
(36, 'Mantis', 16, 2, 600, 6.0, 53.39, 5.41, 3, "2024-12-6"),
(37, 'Rocket Raccoon', 17, 2, 600, 6.0, 55.46, 15.08, 3, "2024-12-6");

--  Team-Ups
INSERT INTO Team_Up (Team_ID, Team_Name, Team_Description) VALUES
(1, 'Allied Agents', 'A legendary partnership between elite spies Black Widow and Hawkeye.'),
(2, 'Ammo Overload', 'Rocket Raccoon supplies additional ammunition to Winter Soldier, enhancing his combat effectiveness.'),
(3, 'Atlas Bond', 'Ant-Man and Wasp coordinate their size-changing abilities for strategic advantages.'),
(4, 'Chilling Charisma', 'Luna Snow and Namor combine their powers, creating icy constructs to aid in battle.'),
(5, 'Dimensional Shortcut', 'Magik and Psylocke utilize teleportation discs for rapid battlefield movement.'),
(6, 'ESU Alumnus', 'Spider-Man and Doctor Octopus, both alumni of Empire State University, collaborate using their scientific expertise.'),
(7, 'Fantastic Four', 'The core members of the Fantastic Four unite, leveraging their unique powers in unison.'),
(8, 'Fastball Special', 'Hulk hurls Wolverine towards enemies for a powerful surprise attack.'),
(9, 'Gamma Charge', 'Hulk and Doctor Strange combine their energies to unleash devastating gamma-infused attacks.'),
(10, 'Guardian Revival', 'Star-Lord and Rocket Raccoon employ advanced technology to revive downed allies swiftly.'),
(11, 'Lunar Force', "Cloak & Dagger enhance Moon Knight's abilities, granting him temporary invisibility."),
(12, 'Metallic Chaos', "Scarlet Witch imbues Magneto's metal constructs with chaotic energy, amplifying their destructive potential."),
(13, 'Planet X Pals', 'Groot and Rocket Raccoon team up, with Groot providing cover and Rocket delivering heavy firepower.'),
(14, 'Ragnarok Rebirth', 'Hela possesses the ability to resurrect Thor or Loki during combat.'),
(15, 'Storming Ignition', 'Human Torch and Storm combine their elemental powers for enhanced area attacks.'),
(16, 'Symbiote Bond', 'Venom and Carnage synchronize their symbiotes for increased aggression and resilience.'),
(17, 'Voltaic Union', 'Thor, Storm, and Captain America channel electrical energy together, boosting their attack potency.');

--  Team Characters
INSERT INTO Team_Characters (Team_ID, Char_ID) VALUES
(1, 11),
(1, 12),
(2, 27),
(2, 37),
(2, 28),
(3, 15),
(3, 35),
(4, 35),
(4, 20),
(4, 33),
(5, 17),
(5, 21),
(5, 10),
(6, 23),
(6, 24),
(7, 18),
(7, 14),
(7, 7),
(7, 32),
(8, 4),
(8, 29),
(8, 7),
(9, 4),
(9, 2),
(9, 16),
(10, 25),
(10, 37),
(10, 30),
(11, 31),
(11, 19),
(12, 22),
(12, 5),
(13, 3),
(13, 37),
(13, 33),
(14, 13),
(14, 8),
(14, 34),
(15, 14),
(15, 26),
(16, 9),
(16, 6),
(16, 23),
(17, 8),
(17, 26),
(17, 1);

--  Game Mode
INSERT INTO Game_Mode (Mode_ID, Map_Mode) VALUES
--  Competitive
(1, 'Domination'),
(2, 'Convoy'),
(3, 'Convergence'),
--  Arcade
(4, 'Conquest'),
(5, 'Doom Match'),
--  Practice
(6, 'Practice Range'),
-- Tutorial
(7, 'Tutorial');

--  Maps
INSERT INTO Map (Map_ID, Map_Name, Mode_ID, Map_Release) VALUES
--  Domination
(1, "Hydra Charteris Base: Hell's Heaven", 1, '2024-12-06'),
(2, "Intergalactic Empire of Wakanda: Birnin T'Challa", 1, '2024-12-06'),
(3, 'Yggsgard: Royal Palace', 1, '2024-05-10'),
--  Convoy
(4, 'Yggsgard: Yggdrasill Path', 2, '2024-05-10'),
(5, 'Tokyo 2099: Spider-Islands', 2, '2024-07-23'),
(6, 'Empire Of Eternal Night: Midtown', 2, '2025-01-10'),
--  Convergence
(7, 'Tokyo 2099: Shin-Shibuya', 3, '2024-05-10'),
(8, 'Intergalactic Empire of Wakanda: Hall of Djalia', 3, '2024-12-06'),
(9, 'Klyntar: Symbiotic Surface', 3, '2024-12-06'),
(10, 'Empire Of Eternal Night: Central Park', 3, '2025-03-21'),
--  Conquest
(11, 'Tokyo 2099: Ninomaru', 4, '2024-12-06'),
--  Doom Match
(12, 'Empire Of Eternal Night: Sanctum Sanctorum', 5, '2025-01-10'),
--  Practice Range
(13, 'Intergalactic Empire of Wakanda: Practice Range', 6, '2024-12-06'),
-- Tutorial
(14, 'Basic & Hero Tutorial -- Tokyo 2099: Shin-Shibuya', 7, '2024-12-06'),
(15, 'Convoy Tutorial -- Yggsgard: Yggdrasill Path', 7, '2024-12-06'),
(16, 'Domination Tutorial -- Yggsgard: Royal Palace - Bifrost Garden', 7, '2024-12-06');


--  Rank
INSERT INTO Ranks (Rank_ID, Rank_Name, Distributions) VALUES
--  Bronze
(1, 'Bronze III', 19.9),
(2, 'Bronze II', 4.91),
(3, 'Bronze I', 3.97),
--  Silver
(4, 'Silver III', 4.41),
(5, 'Silver II', 3.77),
(6, 'Silver I', 3.39),
--  Gold
(7, 'Gold III', 5.65),
(8, 'Gold II', 3.94),
(9, 'Gold I', 3.6),
--  Platinum
(10, 'Platinum III', 5.21),
(11, 'Platinum II', 4.26),
(12, 'Platinum I', 3.81),
--  Diamond
(13, 'Diamond III', 5.44),
(14, 'Diamond II', 4.38),
(15, 'Diamond I', 3.94),
--  Grandmaster
(16, 'Grandmaster III', 6.26),
(17, 'Grandmaster II', 3.66),
(18, 'Grandmaster I', 2.6),
--  Celestial
(19, 'Celestial III', 3.22),
(20, 'Celestial II', 1.45),
(21, 'Celestial I', .8),
--  Eternity
(22, 'Eternity', 1.23),
--  One Above All
(23, 'One Above All', .19);

--  Season
INSERT INTO Season (Season_ID, Season_Name, Season_Description, Start_Date, End_Date) VALUES
(1, "Season 0: Dooms' Rise", 'Launch season introducing core heroes and game mechanics.', '2024-12-06', '2025-01-10'),
(2, 'Season 1: Eternal Night Falls (First Half)', 'Adds new maps, balance updates, and several debut characters.', '2025-01-10', '2025-02-21'),
(3, 'Season 1.5: Eternal Night Falls (Second Half)', 'Continues Season 1 with story progression and unlockable cosmetics.', '2025-01-21', '2025-04-11');

--  Rank Rewards
INSERT INTO Rank_Rewards (Reward_ID, Reward_Name, Rank_Required, Season_ID) VALUES
(1, 'Moon Knight Golden Moonlight Costume', 7, 1),
(2, 'Silver Crest of Honor (S0)', 16, 1),
(3, 'Gold Crest of Honor (S0)', 23, 1),
(4, 'Blood Shield Invisible Woman Costume', 7, 2),
(5, 'Silver Crest of Honor (S1)', 16, 2),
(6, 'Gold Crest of Honor (S1)', 23, 2),
(7, 'Blood Blaze Human Torch Costume', 7, 3),
(8, 'Grandmaster Crest of Honor', 16, 3),
(9, 'Celestial Crest of Honor', 16, 3),
(10, 'Eternity Crest of Honor', 16, 3),
(11, 'One Above All Crest of Honor', 16, 3);