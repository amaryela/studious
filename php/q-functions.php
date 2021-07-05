<?php
include '../include/config.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
// STUDENT END

			//RELOAD PAGE
			  function reloadPage() {
		      location.reload(true);
		    }


			//SCHEDULE UPDATE : WAITING & ON-GOING
		            var reloadSched = setInterval(schedUpdate, 1000);

		            function schedUpdate(){
		            $(document).ready(function(){
		            $('#status_update').load("loaders/sched-waitongoing.php").fadeIn("slow");
		            }); }

				    //STOP : SCHEDULE UPDATE
				            function stopReloadSched() {
				            clearInterval(reloadSched);
				            } 


			//SCHEDULE UPDATE : FINISHED
		            var reloadFinished = setInterval(schedFinished, 1000);

		            function schedFinished(){
		            $(document).ready(function(){
		            $('#status_update').load("loaders/sched-finished.php").fadeIn("slow");
		            }); }

				    //STOP : SCHEDULE UPDATE
				            function stopSchedFinished() {
				            clearInterval(reloadFinished);
				            } 


		    //UPDATE QUESTION STATUS : DONE
		            var doneStatus = setInterval(doneUpdate, 1000);

		            function doneUpdate(){
		            $(document).ready(function(){
		            $('#done').load("loaders/qstn-done-status.php").fadeIn("slow");
		            }); }

				    //STOP : UPDATE QUESTION STATUS : DONE
				            function stopDoneStatus() {
				            clearInterval(doneStatus);
				            }   



		    //UPDATE QUESTION STATUS : READY
		            var readyStatus = setInterval(readyUpdate, 1000);

		            function readyUpdate(){
		            $(document).ready(function(){
		            $('#done').load("loaders/qstn-ready-status.php").fadeIn("slow");
		            }); }

				    //STOP : UPDATE QUESTION STATUS : READY
				            function stopReadyStatus() {
				            clearInterval(readyStatus);
				            }   



		    //UPDATE QUESTION STATUS : FINISHED
		            var finishedStatus = setInterval(finishedUpdate, 1000);

		            function finishedUpdate(){
		            $(document).ready(function(){
		            $('#done').load("loaders/qstn-finished-status.php").fadeIn("slow");
		            }); }

				    //STOP : UPDATE QUESTION STATUS : FINISHED
				            function stopFinishedStatus() {
				            clearInterval(finishedStatus);
				            }   

		    //SHOW QUIZ QUESTION
		            function quizLoad(){
		            $(document).ready(function(){
		            $('#waiting').load("loaders/s-quiz-display.php").fadeIn("slow");
		        }); }
		    

//PROFESSOR END
</script>