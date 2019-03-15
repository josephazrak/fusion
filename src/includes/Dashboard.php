<?php

function linkify_pit($text, $fusionId)
{
    return "<a href='/app/interface/frc/pit/?t=" . $fusionId . "'>". $text ."</a>";
}

class FusionDashboardUtility {
    public static function getPitScoutedTeamAmount($db)
    {
        return $db->instance()->query("SELECT count(*) FROM `pit`")->fetchColumn();
    }

    public static function getTotalTeamAmount($db) {
        return $db->instance()->query("SELECT count(*) FROM `team_manifest`")->fetchColumn();
    }
    public static function suggestNextTeamsStr($db)
    {
        $todo = $db->instance()->query("SELECT `team_manifest`.fusionTeamID, `team_manifest`.frcTeamID FROM `team_manifest` LEFT JOIN `pit` ON `team_manifest`.frcTeamID = `pit`.frcTeamID WHERE `pit`.frcTeamID IS NULL")->fetchAll(PDO::FETCH_ASSOC);
        $selected = array_rand($todo, 3);

        return linkify_pit($todo[$selected[0]]["frcTeamID"], $todo[$selected[0]]["fusionTeamID"]) . ", " . linkify_pit($todo[$selected[1]]["frcTeamID"], $todo[$selected[1]]["fusionTeamID"]) . ", and " . linkify_pit($todo[$selected[2]]["frcTeamID"], $todo[$selected[2]]["fusionTeamID"]);
    }
}