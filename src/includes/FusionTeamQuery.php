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
    }