<?php
    class FusionTeamQuery
    {
        public static function searchByStringOrID($term, $database)
        {
            $sql = "SELECT * FROM `fusion`.`team_manifest` WHERE frcTeamID LIKE '?' or frcTeamName LIKE LOWER(?) or (INSTR(`frcTeamNameSynonyms`, LOWER(?)) > 0);";
            $stmt = $database->instance()->prepare($sql);
            var_dump($database->instance()->errorInfo());
            var_dump($stmt);
            var_dump($database->instance());
            $stmt->execute([$term, $term, $term]);
            var_dump($database->instance()->errorInfo());
            $res = $stmt->fetch();

            var_dump($res);
        }

        public static function getTeamAutocompleteInfoArray($database)
        {
            $sql = "SELECT frcTeamId, frcTeamName FROM `team_manifest`;";
            $stmt = $database->instance()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }