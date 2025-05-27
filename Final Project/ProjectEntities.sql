DROP TABLE IF EXISTS Rank_Rewards, Season, Ranks, Map, Game_Mode,
    Team_Characters, Team_Up, Characters, Roles, Attack_Type;

CREATE TABLE Roles (
    Role_ID INT PRIMARY KEY,
    Role_Name VARCHAR(50),
    Role_Description TEXT
);

CREATE TABLE Attack_Type (
    Attack_ID INT PRIMARY KEY,
    Attack_Name VARCHAR(50)
);

CREATE TABLE Characters (
    Char_ID INT PRIMARY KEY AUTO_INCREMENT,
    Char_Name VARCHAR(50) NOT NULL,
    Role_ID INT,
    Attack_ID INT,
    Health INT,
    Move_Speed FLOAT,
    Win_Rate FLOAT,
    Pick_Rate FLOAT,
    Difficulty INT,
    Char_Release DATE,
    FOREIGN KEY (Role_ID) REFERENCES Roles(Role_ID),
    FOREIGN KEY (Attack_ID) REFERENCES Attack_Type(Attack_ID)
);

CREATE TABLE Team_Up (
    Team_ID INT PRIMARY KEY AUTO_INCREMENT,
    Team_Name VARCHAR(50),
    Team_Description TEXT
);

CREATE TABLE Team_Characters (
    Team_ID INT,
    Char_ID INT,
    PRIMARY KEY (Team_ID, Char_ID),
    FOREIGN KEY (Team_ID) REFERENCES Team_Up(Team_ID),
    FOREIGN KEY (Char_ID) REFERENCES Characters(Char_ID)
);

CREATE TABLE Game_Mode (
    Mode_ID INT PRIMARY KEY,
    Map_Mode VARCHAR(50)
);

CREATE TABLE Map (
    Map_ID INT PRIMARY KEY AUTO_INCREMENT,
    Map_Name VARCHAR(70),
    Mode_ID INT,
    Map_Release DATE,
    FOREIGN KEY (Mode_ID) REFERENCES Game_Mode(Mode_ID)
);

CREATE TABLE Ranks (
    Rank_ID INT PRIMARY KEY,
    Rank_Name VARCHAR(20),
    Distributions FLOAT
);

CREATE TABLE Season (
    Season_ID INT PRIMARY KEY AUTO_INCREMENT,
    Season_Name VARCHAR(70),
    Season_Description TEXT,
    Start_Date DATE,
    End_Date DATE
);

CREATE TABLE Rank_Rewards (
    Reward_ID INT PRIMARY KEY AUTO_INCREMENT,
    Reward_Name VARCHAR(70),
    Rank_Required INT,
    Season_ID INT,
    FOREIGN KEY (Rank_Required) REFERENCES Ranks(Rank_ID),
    FOREIGN KEY (Season_ID) REFERENCES Season(Season_ID)
);
