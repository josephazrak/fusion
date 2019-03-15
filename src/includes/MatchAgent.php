<?php
    class FusionMatchAgent {
        public static function getMatches($teamNumber, $db)
        {
            $sql = "SELECT `matchesPlayed` FROM `team_manifest` WHERE `fusionTeamId`=?";
            $stmt = $db->instance()->prepare($sql);
            $stmt->execute([$teamNumber]);
            return json_decode($stmt->fetchAll(PDO::FETCH_ASSOC)[0]["matchesPlayed"], true);
        }

        public static function doesTeamHaveMatchRecord($teamNumber, $matchNumber, $db)
        {
            return array_key_exists($matchNumber, self::getMatches($teamNumber, $db));
        }

        public static function registerMatch($teamId, $matchId, $data, $db)
        {
            $sql = "UPDATE `team_manifest` SET matchesPlayed=:dataj WHERE `fusionTeamID`=:teamId";
            $oldData = self::getMatches($teamId, $db);

            $oldData[$matchId] = $data;
            $stmt = $db->instance()->prepare($sql);

            $stmt->bindParam("dataj", json_encode($oldData));
            $stmt->bindParam("teamId", $teamId);
            $stmt->execute();
        }

        public static function getMatch($teamId, $matchId, $database)
        {
            return (self::getMatches($teamId, $database))[$matchId];
        }
    }