document.addEventListener("DOMContentLoaded", function () {
  const semesterLinks = document.querySelectorAll(".semester-link");

  // Function to show or hide the subject group when a semester is clicked
  function toggleSubjectGroup(subjectGroup) {
    subjectGroup.style.display = subjectGroup.style.display === "block" ? "none" : "block";
  }
  function toggleSemesterLinkColor(semesterLink) {
    semesterLink.style.background = semesterLink.style.background === "#8685f4" ? "#4285f4" : "#8685f4";
  }

  // Event listener for each semester link
  semesterLinks.forEach((semesterLink) => {
    semesterLink.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent the click event from bubbling to the document
      const target = event.target;
      const subjectGroup = target.nextElementSibling; // Get the subject group
      toggleSubjectGroup(subjectGroup);
      toggleSemesterLinkColor(semesterLink);
    });
  });

  // Event listener to hide the subject group when clicking outside the semester-gp
  document.addEventListener("click", function (event) {
    const targetElement = event.target;
    const semesterGroups = document.querySelectorAll(".semester-gp");
    if (!targetElement.classList.contains("semester-link")) {
      semesterGroups.forEach((semesterGroup) => {
        const subjectGroup = semesterGroup.querySelector(".subject-group");
        subjectGroup.style.display = "none";
      });
    }
  });
});
