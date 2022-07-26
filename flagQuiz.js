// Start selected 

var score = 0;
var question = 0;
var answer = null;
var previous_questions = [];

function get_question(selectedflag)
{
    previous_questions.push(answer);
    console.log(previous_questions);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: 'ajax_processer.php',
            data: {action: "next", choice: selectedflag, question: question, previous_questions: previous_questions},
            success: function(data)
            {
            answer = data.answer;
            $("#quiz-wrap").html(data.html);
        }
    }); 
}


function show_results()
{
    $.ajax({
        type: "POST",
        dataType: "json",
        url: 'ajax_processer.php',
        data: {action: "end", score: score},
        success: function(data)
        {
            $("#quiz-wrap").html(data.html);
        }
    });
}


$( "#start" ).on( "click", function () {
    question++;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: 'ajax_processer.php',
            data: {action: "start", question: question},
            success: function(data)
            {
            answer = data.answer;
            $("#quiz-wrap").html(data.html);
        }
    }); 
});



$(".container").delegate('.choice', 'click', function(){
    
            //  define score 
            let selectedflag = $(this).attr('id');
            console.log(selectedflag);
            console.log(answer);

            question++;

            if(selectedflag == answer) {
                score++;
                console.log("score:" + score);
            }
            if(question == 11) {
                console.log("end");
                show_results();

                // Defined total score at top or does 
                // it need to be in functions?

            }
            else {
                get_question(selectedflag);
            }
    //         console.log(score);
    // get_question(selectedflag);


    // increment score, use var to keep score throughout 
    // $score++
});
  

// Use Ajax to get server retrieves 1st question 

// Server renders in HTML

// Jquery outputs HTML

