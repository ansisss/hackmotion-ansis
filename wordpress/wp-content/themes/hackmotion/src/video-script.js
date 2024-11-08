document.addEventListener("DOMContentLoaded", function () {
  const video = document.getElementById("trainingVideo");
  const drillComponents = document.querySelectorAll(".drill-component");
  const progressBar = document.getElementById("progress-bar");
  let lastActivatedComponent = null;

  function checkDrillTimes(currentTime) {
    drillComponents.forEach((component) => {
      const drillTime = parseInt(component.getAttribute("data-time"), 10);
      const description = component.querySelector(".drill-description");
      const chevron = component.querySelector(".chevron");

      if (Math.floor(currentTime) === drillTime) {
        if (lastActivatedComponent && lastActivatedComponent !== component) {
          lastActivatedComponent.querySelector(".drill-description").classList.add("hidden");
          lastActivatedComponent.querySelector(".chevron").classList.remove("!rotate-180");
        }

        description.classList.remove("hidden");
        chevron.classList.add("!rotate-180");
        lastActivatedComponent = component;
      }
    });
  }

  function updateProgress(percentage) {
    percentage = Math.min(Math.max(percentage, 0), 98);

    if (window.innerWidth < 1024) {
      progressBar.style.width = percentage + "%";
      progressBar.style.height = "100%";
    } else {
      progressBar.style.height = percentage + "%";
      progressBar.style.width = "100%";
    }
  }

  if (video) {
    video.addEventListener("timeupdate", () => {
      checkDrillTimes(video.currentTime);

      const percentage = (video.currentTime / video.duration) * 100;
      updateProgress(percentage);
    });
  }

  window.seekTo = function (seconds) {
    video.currentTime = seconds;
    video.play();
  };

  window.scrollToVideo = function () {
    video.scrollIntoView({ behavior: "smooth", block: "center" });
  };
});
