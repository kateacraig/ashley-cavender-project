// Ashley Cavender Campaign Website - Main JavaScript

// ==========================================
// Hamburger Menu
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburger) {
    hamburger.addEventListener("click", function () {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  }

  document.addEventListener("click", function (e) {
    if (!e.target.closest("nav") && !e.target.closest(".hamburger")) {
      if (navMenu && navMenu.classList.contains("active")) {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
      }
    }
  });
});

// ==========================================
// Desktop/Tablet/Mobile Countdown Clock
// ==========================================
function updateCountdown() {
  const daysEl = document.getElementById("days");

  // Only run on pages that have the countdown clock
  if (!daysEl) return;

  const targetDate = new Date("2026-08-06T04:00:00Z");
  const now = new Date();
  const diff = targetDate - now;

  if (diff <= 0) {
    ["days", "hours", "minutes", "seconds"].forEach((id) => {
      document.getElementById(id).textContent = "00";
      document.getElementById(`${id}-mobile`).textContent = "00";
    });
    return;
  }

  const totalSeconds = Math.floor(diff / 1000);
  const totalMinutes = Math.floor(totalSeconds / 60);
  const totalHours = Math.floor(totalMinutes / 60);
  const totalDays = Math.floor(totalHours / 24);

  const days = totalDays;
  const hours = totalHours % 24;
  const minutes = totalMinutes % 60;
  const seconds = totalSeconds % 60;

  const pad = (n) => String(n).padStart(2, "0");

  document.getElementById("days").textContent = pad(days);
  document.getElementById("hours").textContent = pad(hours);
  document.getElementById("minutes").textContent = pad(minutes);
  document.getElementById("seconds").textContent = pad(seconds);

  document.getElementById("days-mobile").textContent = pad(days);
  document.getElementById("hours-mobile").textContent = pad(hours);
  document.getElementById("minutes-mobile").textContent = pad(minutes);
  document.getElementById("seconds-mobile").textContent = pad(seconds);
}

updateCountdown();
setInterval(updateCountdown, 1000);

// ==========================================
// Candidate Carousel
// ==========================================
const candidateCarousel = document.querySelector(".candidate-carousel");
const candidateCarouselSlides = document.getElementById(
  "candidateCarouselSlides"
);
const candidateSlides = candidateCarousel
  ? candidateCarousel.querySelectorAll(".carousel-slide")
  : [];

if (
  candidateCarousel &&
  candidateCarouselSlides &&
  candidateSlides.length > 0
) {
  let candidateCurrentIndex = 0;
  let candidateSlidesToShow = getCandidateSlidesToShow();
  let candidateIsTransitioning = false;
  let candidateAutoAdvanceInterval;

  function setupCandidateInfiniteLoop() {
    const existingClones = candidateCarouselSlides.querySelectorAll(".clone");
    existingClones.forEach((clone) => clone.remove());

    for (let i = 0; i < candidateSlidesToShow; i++) {
      const clone = candidateSlides[i].cloneNode(true);
      clone.classList.add("clone");
      candidateCarouselSlides.appendChild(clone);
    }

    for (
      let i = candidateSlides.length - candidateSlidesToShow;
      i < candidateSlides.length;
      i++
    ) {
      const clone = candidateSlides[i].cloneNode(true);
      clone.classList.add("clone");
      candidateCarouselSlides.insertBefore(
        clone,
        candidateCarouselSlides.firstChild
      );
    }

    candidateCurrentIndex = candidateSlidesToShow;
    updateCandidateCarouselPosition(false);
  }

  function getCandidateSlidesToShow() {
    return window.innerWidth <= 460 ? 1 : 4;
  }

  function updateCandidateCarouselPosition(animate = true) {
    const slideWidth = 100 / candidateSlidesToShow;
    const offset = -candidateCurrentIndex * slideWidth;

    if (animate) {
      candidateCarouselSlides.style.transition = "transform 1s ease-in-out";
    } else {
      candidateCarouselSlides.style.transition = "none";
    }

    candidateCarouselSlides.style.transform = `translateX(${offset}%)`;
  }

  function candidateNextSlide() {
    if (candidateIsTransitioning) return;

    candidateIsTransitioning = true;
    candidateCurrentIndex++;
    updateCandidateCarouselPosition(true);

    setTimeout(() => {
      if (
        candidateCurrentIndex >=
        candidateSlides.length + candidateSlidesToShow
      ) {
        candidateCurrentIndex = candidateSlidesToShow;
        updateCandidateCarouselPosition(false);
      }
      candidateIsTransitioning = false;
    }, 1000);
  }

  let candidateResizeTimeout;
  window.addEventListener("resize", function () {
    clearTimeout(candidateResizeTimeout);
    candidateResizeTimeout = setTimeout(() => {
      const newSlidesToShow = getCandidateSlidesToShow();
      if (newSlidesToShow !== candidateSlidesToShow) {
        candidateSlidesToShow = newSlidesToShow;
        setupCandidateInfiniteLoop();
      }
    }, 250);
  });

  setupCandidateInfiniteLoop();
  candidateAutoAdvanceInterval = setInterval(candidateNextSlide, 2000);
}

// ==========================================
// Early Voting Modal
// ==========================================
const earlyVotingBtn = document.getElementById("earlyVotingBtn");
const earlyVotingModal = document.getElementById("earlyVotingModal");
const modalClose = document.getElementById("modalClose");

if (earlyVotingBtn && earlyVotingModal) {
  earlyVotingBtn.addEventListener("click", function (e) {
    e.preventDefault();
    earlyVotingModal.classList.add("active");
    document.body.style.overflow = "hidden"; // prevents background scrolling
  });

  modalClose.addEventListener("click", function () {
    earlyVotingModal.classList.remove("active");
    document.body.style.overflow = "";
  });

  // Close when clicking outside the image
  earlyVotingModal.addEventListener("click", function (e) {
    if (e.target === earlyVotingModal) {
      earlyVotingModal.classList.remove("active");
      document.body.style.overflow = "";
    }
  });

  // Close with Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && earlyVotingModal.classList.contains("active")) {
      earlyVotingModal.classList.remove("active");
      document.body.style.overflow = "";
    }
  });
}
