<?php
class Reactions
{
    static function setReaction($postArray){
        global $con;
        $array = [];
        if (!empty($postArray)) {

            if (isset($postArray['name']) && $postArray['name'] != '') {
                $name = stripslashes(trim($postArray['name']));
            } else {
                $array['error'][] = "Name not set in array";
            }
            if (isset($postArray['email']) && filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)) {
                $email = stripslashes(trim($postArray['email']));
            } else {
                $array['error'][] = "Invalid email format";
            }

            if (isset($postArray['message']) && $postArray['message'] != '') {
                $message = stripslashes(trim($postArray['message']));
            } else {
                $array['error'][] = "Message not set in array";
            }

            if (empty($array['error'])) {   
                $srqry = $con->prepare("INSERT INTO reactions (name, email, message) VALUES (?, ?, ?);");
                if ($srqry === false) {
                    prettyDump(mysqli_error($con));
                }
                
                $srqry->bind_param('sss', $name, $email, $message);
                if ($srqry->execute() === false) {
                    prettyDump(mysqli_error($con));
                } else {
                    $array['success'] = "Reaction saved successfully";
                }
            
                $srqry->close();
            }

            return $array;
        }
    }
    
    static function getReactions(){
        global $con;
        $array = [];
        $grqry = $con->prepare("SELECT id, name, email, message FROM reactions;");
        if($grqry === false) {
            prettyDump(mysqli_error($con));
        } else {
            $grqry->execute();
            $result = $grqry->get_result();
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
            $grqry->close();
        }
        return $array;
    }

    static function deleteReaction($id) {
        global $con;
        $drqry = $con->prepare("DELETE FROM reactions WHERE id = ?");
        if ($drqry === false) {
            prettyDump(mysqli_error($con));
        }
        $drqry->bind_param('i', $id);
        if ($drqry->execute() === false) {
            prettyDump(mysqli_error($con));
        }
        $drqry->close();
    }

    static function getReactionById($id) {
        global $con;
        $reaction = [];
        $grqry = $con->prepare("SELECT id, name, email, message FROM reactions WHERE id = ?");
        if ($grqry === false) {
            prettyDump(mysqli_error($con));
        }
        $grqry->bind_param('i', $id);
        if ($grqry->execute()) {
            $grqry->bind_result($id, $name, $email, $message);
            $grqry->fetch();
            $reaction = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'message' => $message
            ];
        }
        $grqry->close();
        return $reaction;
    }

    static function updateReaction($postArray) {
        global $con;
        $array = [];
        if (!empty($postArray)) {
            $id = intval($postArray['id']);
            $name = stripslashes(trim($postArray['name']));
            $email = stripslashes(trim($postArray['email']));
            $message = stripslashes(trim($postArray['message']));

            $urqry = $con->prepare("UPDATE reactions SET name = ?, email = ?, message = ? WHERE id = ?");
            if ($urqry === false) {
                prettyDump(mysqli_error($con));
            }
            $urqry->bind_param('sssi', $name, $email, $message, $id);
            if ($urqry->execute() === false) {
                prettyDump(mysqli_error($con));
            } else {
                $array['success'] = "Reaction updated successfully";
            }
            $urqry->close();
        }
        return $array;
    }
}
?>