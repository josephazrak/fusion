<?php
    class FusionTeamQuery
    {
        public static function searchByStringOrID($term, $database)
        {
            $sql = 'SELECT * FROM `fusion`.`team_manifest` WHERE `frcTeamID`=:term OR `frcTeamNameSynonyms` LIKE (CONCAT("%",:term,"%"));';
            $stmt = $database->instance()->prepare($sql);
            $stmt->bindParam("term", $term);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $res;
        }

        public static function getTeamAutocompleteInfoArray($database)
        {
            $sql = "SELECT frcTeamId, frcTeamName FROM `team_manifest`;";
            $stmt = $database->instance()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getTeamInfoByInternalId($id, $database)
        {
            $sql = "SELECT * FROM `team_manifest` WHERE fusionTeamId=:id";
            $stmt = $database->instance()->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            if (!$res)
                return false; // No such team.

            return $res;
        }
    }