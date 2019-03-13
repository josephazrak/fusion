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

    public static function getAllDataAndParse($id, $db, $doJsonDecode=true)
    {
        $sql = "SELECT * FROM `pit` WHERE fusionTeamID=?";
        $stmt = $db -> instance() -> prepare($sql);
        $stmt -> execute([$id]);
        $res = $stmt -> fetchAll(PDO::FETCH_ASSOC)[0];

        $buffer = [
            "fusionTeamID" => $res["fusionTeamID"],
            "frcTeamID" => $res["frcTeamID"],
            "intake" => ($doJsonDecode? json_decode($res["intake"], true): $res["intake"]),
            "driveoff" => ($doJsonDecode? json_decode($res["driveoff"], true): $res["driveoff"]),
            "pieceability" => ($doJsonDecode? json_decode($res["pieceability"], true): $res["pieceability"]),
            "endgame" => ($doJsonDecode? json_decode($res["endgame"], true): $res["endgame"]),
            "notes" => $res["notes"],
            "scout" => $res["scout"]
        ];

        return $buffer;
    }

    public static function overwritePitEntry($internalId, $data, $author, $database)
    {
        $sql = "UPDATE `pit` SET `intake`=:intake, `driveoff`=:driveoff, `pieceability`=:pieceability, `endgame`=:endgame, `notes`=:notes, `scout`=:scout WHERE `fusionTeamId`=:fusionTeamId";
        $stmt = $database -> instance() -> prepare($sql);

        $stmt -> bindParam("intake", json_encode($data["intake"]));
        $stmt -> bindParam("driveoff", json_encode($data["driveoff"]));
        $stmt -> bindParam("pieceability", json_encode($data["pieceability"]));
        $stmt -> bindParam("endgame", json_encode($data["endgame"]));
        $stmt -> bindParam("notes", $data["notes"]);
        $stmt -> bindParam("scout", $author);
        $stmt -> bindParam("fusionTeamId", $internalId);

        return $stmt -> execute();
    }

    public static function createPitEntry($internalId, $frcId, $data, $author, $database)
    {
        $sql = "INSERT INTO `pit`(fusionTeamId, frcTeamId, intake, driveoff, pieceability, endgame, notes, scout) VALUES(:fusionId, :frcId, :intake, :driveoff, :pieceability, :endgame, :notes, :scout)";
        $stmt = $database -> instance() -> prepare($sql);

        $stmt -> bindParam("fusionId", $internalId);
        $stmt -> bindParam("frcId", $frcId);
        $stmt -> bindParam("intake", json_encode($data["intake"]));
        $stmt -> bindParam("driveoff", json_encode($data["driveoff"]));
        $stmt -> bindParam("pieceability", json_encode($data["pieceability"]));
        $stmt -> bindParam("endgame", json_encode($data["endgame"]));
        $stmt -> bindParam("notes", $data["notes"]);
        $stmt -> bindParam("scout", $author);

        return $stmt -> execute();
    }
    public static function registerSnapshotByInternalId($internalId, $author, $database)
    {
        // Retrieve values under `pit` table: intake, driveoff, pieceability, endgame, notes
        $latestData = self::getAllDataAndParse($internalId, $database, false);

        // Create new entry under `pit_revisions` table with random revisionId
        $sql = "INSERT INTO `pit_revisions`(revisionId,forTeamId,byUsername,intake,driveoff,pieceability,endgame,notes,datetime) VALUES(:revId, :forId, :author, :intake, :driveoff, :pieceability, :endgame, :notes, now())";
        $stmt = $database -> instance() -> prepare($sql);

        $revisionId = bin2hex(openssl_random_pseudo_bytes(20));

        $stmt -> bindParam("revId", $revisionId);
        $stmt -> bindParam("forId", $internalId);
        $stmt -> bindParam("author", $author);
        $stmt -> bindParam("intake", $latestData["intake"]);
        $stmt -> bindParam("driveoff", $latestData["driveoff"]);
        $stmt -> bindParam("pieceability", $latestData["pieceability"]);
        $stmt -> bindParam("endgame", $latestData["endgame"]);
        $stmt -> bindParam("notes", $latestData["notes"]);

        $stmt -> execute();

        return $revisionId;
    }
}