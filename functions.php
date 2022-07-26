<?php

// debugging function
function izzy_pre($printme, $title = false)
{
	echo "<hr><h2>" . $title . "</h2>";
	echo "<pre>".print_r($printme, true)."</pre>";
}

// outputs flag question
function get_question($post)
{
    if ($_SERVER['HTTP_HOST'] == "localhost/flagQuiz") {
        // local database details
        $dbserver = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbdatabase = "flag_quiz";
    } elseif ($_SERVER['HTTP_HOST'] == "izzy.milestonedesign.co.uk") {
        // test site database details
        $dbserver = "sdb-w.hosting.stackcp.net";
        $dbusername = "izzyFlags-323133d67a";
        $dbpassword = "fdkj-Hkds-632-hH7";
        $dbdatabase = "izzyFlags-323133d67a";
    }
    elseif ($_SERVER['HTTP_HOST'] == "flagquiz.local") {
        // test site database details
        $dbserver = "127.0.0.1";
        $dbusername = "root";
        $dbpassword = "Linc0ln777";
        $dbdatabase = "flagquiz";
    }
    // connecting to database
    $db = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);

    // selecting all from flags table by random
    $sql = "SELECT * from flags ORDER BY RAND()";
        
    // fetching database result
    $result = mysqli_query($db,$sql);
    
    // setting variable to 0 
    // creating array of choices
    $i = 0; 
    $choices = array();

    // whilst flag row results
    while ($row = mysqli_fetch_assoc($result)) { 
        if (
            !isset($svg) &&
            $row["flag_image"] &&
            !isset($return['answer']) &&
            (!isset($post['previous_questions']) || !in_array($row['id'], $post['previous_questions']))
        ) {
            // if flag image exists, has no answer, no svg
            // and has not been shown before..
            // then pass the unique flag id to answer
            // and display the flags image
            $return['answer'] = $row['id'];
            $svg = $row["flag_image"];
        } 
        
        if (
            count($choices) == 3 &&
            !isset ($return['answer'])
        ) {
            // if there are 3 choices
            // and answer is not set
            // continue
            continue;
        }

        // 
        $choices[$i]['name'] = $row['name'];
        $choices[$i]['id'] = $row['id'];

        if (count($choices) == 4) {
            // if choice amount reaches 4
            // end
            break;
        }
            // 
            $i++;
        }

    $return['choices'] = $choices;

    $return['html'] = 
    "<div id='flag-img'><img src='$svg'></div>
        <div id='question-count'>".$post['question']." / 10</div>
            <div class='choice-wrap'>
                <div id='".$choices[0]['id']."' class='choice'>".$choices[0]['name']."</div>
                <div id='".$choices[1]['id']."' class='choice'>".$choices[1]['name']."</div>
                <div id='".$choices[2]['id']."' class='choice'>".$choices[2]['name']."</div>
                <div id='".$choices[3]['id']."' class='choice'>".$choices[3]['name']."</div>
            </div>";

    return $return;
}

function final_score($totalscore)
{
    if ($totalscore <= 4) {
        // if total score is equal to or less than 4
        // output message
        $message = "sort it out";
    } elseif ($totalscore >= 5 && $totalscore < 7) {
        // if total score is more than or equal to 5
        // and less than 7
        // output messasge
        $message = "bang average";
    } elseif ($totalscore >= 7 && $totalscore < 11) {
        // if score is more than or equal to 7
        // and less than 11
        // output message
        $message = "flag lord";
    }

    $return['html'] = 
        "<div id='flag-img'>".$totalscore." / 10</div>
        <div id='message'>".$message."</div>";
    
    return $return;
}
