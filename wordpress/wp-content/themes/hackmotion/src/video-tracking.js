document.addEventListener("DOMContentLoaded", function () {
  var video = document.querySelector("video"); // Assuming there's a single video tag on the page
  if (!video) return;

  function getUserIdFromCookie() {
    var name = "user_id=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i].trim();
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  var videoStartTime = 0;
  var videoEndTime = 0;

  // Event listener for when the video starts playing
  video.addEventListener("play", function () {
    // Record the start time when the video starts
    videoStartTime = video.currentTime;
  });

  // Event listener for when the video ends
  //   video.addEventListener("ended", function () {
  //     // Record the end time when the video finishes
  //     videoEndTime = video.currentTime;

  //     // Send the data to the server using AJAX once the video finishes
  //     sendVideoData(videoStartTime, videoEndTime);
  //   });

  // Event listener for when the user pauses the video or navigates away
  video.addEventListener("pause", function () {
    // If the video is paused, we can still send the data with the last known time
    videoEndTime = video.currentTime;
    sendVideoData(videoStartTime, videoEndTime);
  });

  // Function to send video start and end times to the server
  function sendVideoData(startTime, endTime) {
    var videoUrl = video.currentSrc; // Get the video URL
    var currentUrl = window.location.href; // Get the referring page URL
    var userId = getUserIdFromCookie();
    // Prepare the data to be sent to the server
    var data = {
      action: "track_video_playback",
      video_url: videoUrl,
      start_time: startTime,
      end_time: endTime,
      referrer: currentUrl,
      user_id: userId,
    };

    // Send the data to the server using AJAX
    jQuery.post(ajaxurl, data, function (response) {
      console.log("Video playback data sent:", response);
    });
  }
});
