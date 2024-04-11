// Function to get the current time and set the count down time to the next midnight
function getNextMidnight() {
  var now = new Date();
  var midnight = new Date(now);
  midnight.setHours(24, 0, 0, 0); // Set time to next midnight
  return midnight.getTime();
}

// Set the date we're counting down to
var countDownDate = getNextMidnight();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get current time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // If count down is finished, reset countDownDate to next midnight
  if (distance <= 0) {
    countDownDate = getNextMidnight();
    distance = countDownDate - now;
  }

  // Time calculations for hours, minutes and seconds
  var hours = Math.floor(distance / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("hours").innerHTML = hours + " ";
  document.getElementById("minutes").innerHTML = minutes + " ";
  document.getElementById("seconds").innerHTML = seconds + " ";

}, 1000);
