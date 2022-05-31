<p align="center">
  <img src="https://i.imgur.com/w7H4AYH.png" width="350" title="Pangaea Fusion logo">
</p>

<p align="middle">
  <img src="https://i.imgur.com/HODq7M1.png" width="400" />
  <img src="https://i.imgur.com/EmR4fLK.png" width="400" />
</p>

---

<p align="center">
Pangaea Fusion is <a href="https://robotics.asbindia.org/">Team Pangaea</a>'s solution for rapid, flexible scouting. Written by Joseph Azrak, it allows for both pit scouting and in-match scouting. <br><br>
Currently, Fusion only supports data entry for Destination: Deep Space.
</p>

<p align="center">
	<b>NOTE:</b> This code was not written with the intention of being viewed by others. Some parts of it may be inefficient, difficult to read, or purposeless. However, this is rare.
</p>

---

## Running Pangaea Fusion
### Environment
Pangaea Fusion has the following dependencies:
- PHP >= v7.0
- MySQL >= 8.0.0
- Apache httpd

By default, Fusion connects to a MySQL server on `127.0.0.1` and looks for a database named `fusion`. Check [Database Structure](#database-structure) for its structure.

### Database Structure

As mentioned, Fusion connects to MySQL@127.0.0.1:fusion. The credientials can be changed in `src/includes/Database.php`. The database is structured as follows:

  Table Name  | Purpose
------------- | -------
team_manifest | Ties FRC team names/ IDs to Fusion IDs, and holds match data performance. `frcTeamNameSynonyms` is deprecated.
logs          | Holds some system log data. Have to check MySQL db manually; no UI viewer as of now.
pit           | Holds pit data for each `fusionTeamID`.
pit_revisions | Holds data on each revision of pit data, and who made that revision. Helps with restoring earlier data
users         | Holds user data. There is no notion of privilege in Fusion; all users can edit everything. Hashed+salted PW storage.

Table *team_manifest*
```sql
CREATE TABLE `team_manifest` (
  `fusionTeamID` int(11) NOT NULL AUTO_INCREMENT,
  `frcTeamName` text COLLATE utf8_unicode_ci NOT NULL,
  `frcTeamID` text COLLATE utf8_unicode_ci NOT NULL,
  `frcTeamNameSynonyms` text COLLATE utf8_unicode_ci NOT NULL,
  `matchesPlayed` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fusionTeamID`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

Table *logs*
```sql
CREATE TABLE `logs` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `severity` text COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

Table *pit*

```sql
CREATE TABLE `pit` (
  `fusionTeamID` int(11) NOT NULL,
  `frcTeamID` int(11) NOT NULL,
  `intake` text COLLATE utf8_unicode_ci NOT NULL,
  `driveoff` text COLLATE utf8_unicode_ci,
  `pieceability` text COLLATE utf8_unicode_ci,
  `endgame` text COLLATE utf8_unicode_ci,
  `notes` text COLLATE utf8_unicode_ci,
  `scout` text COLLATE utf8_unicode_ci,
  KEY `fusionId` (`fusionTeamID`),
  CONSTRAINT `pit_ibfk_1` FOREIGN KEY (`fusionTeamID`) REFERENCES `team_manifest` (`fusionTeamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

```

Table *pit_revisions*

```sql
CREATE TABLE `pit_revisions` (
  `tableId` int(11) NOT NULL AUTO_INCREMENT,
  `revisionId` text COLLATE utf8_unicode_ci NOT NULL,
  `forTeamId` text COLLATE utf8_unicode_ci NOT NULL,
  `byUsername` text COLLATE utf8_unicode_ci NOT NULL,
  `intake` text COLLATE utf8_unicode_ci NOT NULL,
  `driveoff` text COLLATE utf8_unicode_ci NOT NULL,
  `pieceability` text COLLATE utf8_unicode_ci NOT NULL,
  `endgame` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tableId`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

```

Table *users*

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `friendlyname` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

(**Note**: password hashing and salting is handled by PHP `password_hash()` and `password_verify()`).

## Project Structure
### assets/

`src/assets/` holds:
- Image data, such as logos
- Frameworks, such as jQuery, Materialize, and Bootstrap
- Some custom stylesheet data
- Some custom JavaScript

### includes/

`src/includes/` holds most PHP code. Actual UI pages include these using the following boilerplate:
```php
<?php
    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "[CLASS NAME].php");
?>
```

Basic explanations of file purposes:

File | Purpose | Exports
--- | --- | ---
Dashboard.php | Filename somewhat misleading. Defines `getPitScoutedTeamAmount`, `getTotalTeamAmount`, `suggestNextTeamsStr`. | FusionDashboardUtility::getPitScoutedTeamAmount, FusionDashboardUtility::getTotalTeamAmount, FusionDashboardUtility::suggestNextTeamsStr
Database.php | All UI pages which need database connectivity include this; has database login credientials. | FusionDBInteface::connect, FusionDBInteface::instance
EnvDetect.php | Very crude code for environment detection. `Env::Get()` returns `dev` or `prod`. | Env::Get
Footer.php | Code for rendering a Materialize footer. | UIFooter::render
FusionTeamQuery.php | Exposes internal methods to search team info by Fusion ID, and powers the Fusion search bar. `getTeamAutocompleteInfoArray` is deprecated. | FusionTeamQuery::searchByStringOrId, FusionTeamQuery::getTeamAutocompleteInfoArray, FusionTeamQuery::getTeamInfoByInternalId, teamExistsByInternalId
GenericRequest.php | API endpoints include this; it dictates API response format. | APIRequest->fail, APIRequest->message, APIRequest->terminate
Logging.php | Interface to log events. Used as `Logger::addLogEntry(...)`. `Logger::getAllLogs()` is unused, but should work theoretically. | Logger->addLogEntry, Logger->getAllLogs
MatchAgent.php | Interface for match scouting. Adds JSON match data to `team_manifest`. | FusionMatchAgent::getMatches, FusionMatchAgent::doesTeamHaveMatchRecord, FusionMatchAgent::registerMatch, FusionMatchAgent::getMatch
Navbar.php | Renders navbar in Bootstrap and Materialize. WARNING: VERY BAD CODE. | Navbar->setNavbarType, Navbar->setNavbarFramework, Navbar->bindParam, Navbar->setAuthProvider, Navbar->render
PitScoutingInterface.php | Interface for pit scouting. Exposes methods to save JSON pit data, revision data, and get data. | PitScoutingInterface::doesTeamHaveData, PitScoutingInterface::getAllDataAndParse, PitScoutingInterface::overwritePitEntry, PitScoutingInterface::createPitEntry, PitScoutingInterface::registerSnapshotByInternalId
Session.php | Login state interface. | FusionSessionInterface::isLoggedIn, FusionSessionInterface::setIsLoggedIn, FusionSessionInterface::setLoggedInUser, FusionSessionInterface::destroySession, FusionSessionInterface::getLoggedInUsername, FusionSessionInterface::getLoggedInNiceName
User.php | Exposes methods to check login, and get the "nice name" of a user. | FusionUser->doesLoginWork, FusionUser->getNiceName

