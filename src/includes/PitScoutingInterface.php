<?php
class PitScoutingInterface
{
    public static function doesTeamHaveData($id, $db)
    {
        $sql = "SELECT scout FROM `pit` WHERE fusionTeamId=?";
        $stmt = $db -> instance() -> prepare($sql);
        $stmt -> execute([$id]);
        $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return (!!$res? $res[0]["scout"]: false);
    }

    public static function getAllDataAndParse($id, $db)
    {
        $sql = "SELECT * FROM `pit` WHERE fusionTeamID=?";
        $stmt = $db -> instance() -> prepare($sql);
        $stmt -> execute([$id]);
        $res = $stmt -> fetchAll(PDO::FETCH_ASSOC)[0];

        $buffer = [
            "fusionTeamID" => $res["fusionTeamID"],
            "frcTeamID" => $res["frcTeamID"],
            "intake" => json_decode($res["intake"], true),
            "driveoff" => json_decode($res["driveoff"], true),
            "pieceability" => json_decode($res["pieceability"], true),
            "endgame" => json_decode($res["endgame"], true),
            "scout" => $res["scout"]
        ];

        return $buffer;
    }
}